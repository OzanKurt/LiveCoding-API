<?php

namespace Kurt\LiveCoding;

use Kurt\LiveCoding\AuthTokens\FileAuthToken;
use Kurt\LiveCoding\AuthTokens\SessionAuthToken;
use Kurt\LiveCoding\Utilities\FileManager;

class LiveCoding
{
    use HelperMethods;

    /**
     * LiveCodingTV client instance.
     *
     * @var Kurt\LiveCoding\Client
     */
    protected $client;

    protected $state;

    protected $is_authorized;

    protected $auth_link;

    protected $api_url = 'https://www.livecoding.tv:443/api';
    protected $token_url = 'https://www.livecoding.tv/o/token/';

    protected $api_req_params;
    protected $token_req_params;
    protected $token_req_headers;

    public function __construct($client)
    {
        $this->client = $client;

        $this->state = uniqid();

        $this->initializeTokens();

        $query = [
            'scope'         => $this->client->getScope()->getText(),
            'state'         => $this->state,
            'redirect_uri'  => $this->client->getRedirectUrl(),
            'client_id'     => $this->client->getId(),
            'response_type' => 'code',
        ];

        $this->auth_link = 'https://www.livecoding.tv/o/authorize/?'.http_build_query($query);

        $this->token_req_headers = [
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'Authorization: Basic '.base64_encode($this->client->getId().':'.$this->client->getSecret()),
        ];

        $this->token_req_params = [
            'grant_type'   => '',
            'code'         => $this->tokens->getCode(),
            'redirect_uri' => $this->client->getRedirectUrl(),
        ];

        $this->api_req_params = [
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'Authorization: TOKEN_TYPE_DEFERRED ACCESS_TOKEN_DEFERRED',
        ];

// Check the storage for existing tokens
        if ($this->tokens->isAuthorized()) {
            // Here we are authorized from a previous request
            // Nothing to do - yay
        } elseif (isset($_GET['state']) && $_GET['state'] == $this->tokens->getState()) {
            // Here we are returning from user auth approval link
            $this->fetchTokens($_GET['code']);
        } else {
            // Here we have not yet been authorized
// Save the state before displaying auth link
            $this->tokens->setState($this->state);
        }
    }

    /**
     * [initializeTokens description].
     * 
     * @return [type] [description]
     */
    public function initializeTokens()
    {
        if ($this->client->usesFileStorage()) {
            $fileStorage = $this->client->getStorage();
            $fileManager = new FileManager($fileStorage->getPath());
            $this->tokens = new FileAuthToken($fileManager);
        } elseif ($this->client->usesSessionStorage()) {
            $this->tokens = new SessionAuthToken();
        } else {
            throw new \Exception('Storage type is not valid.');
        }
    }

    /**
     * [fetchTokens description].
     * 
     * @param [type] $code [description]
     *
     * @return [type] [description]
     */
    private function fetchTokens($code)
    {
        $this->tokens->setCode($code);
        $this->token_req_params['code'] = $code;
        $this->token_req_params['grant_type'] = 'authorization_code';

        $res = $this->post_url_contents($this->token_url, $this->token_req_params, $this->token_req_headers);
        // Store access tokens
        $this->tokens->storeTokens($res);
    }

    private function post_url_contents($url, $query, $headers = [])
    {
        $query['client_id'] = $this->client->getId();

        try {
            $ch = curl_init();
            $timeout = 5;

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($query));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $response = curl_exec($ch);

            if (false === $response) {
                throw new \Exception(curl_error($ch), curl_errno($ch));
            }

            curl_close($ch);
        } catch (\Exception $e) {
            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }

        return $response;

        // return $response->getBody()->getContents();
    }

    /**
     * Refresh stale tokens.
     */
    private function refreshToken()
    {
        $this->token_req_params['grant_type'] = 'refresh_token';
        $this->token_req_params['refresh_token'] = $this->tokens->getRefreshToken();
        $res = $this->post_url_contents($this->token_url, $this->token_req_params, $this->token_req_headers);
        // Store access tokens
        $this->tokens->storeTokens($res);
    }

    /**
     * Request API data.
     *
     * @param string $data_path - The data to get e.g. 'livestreams/channelname/'
     *
     * @return string - The requested data as JSON string or error message
     */
    private function sendGetRequest($data_path)
    {
        $this->api_req_params[2] = $this->tokens->makeAuthParam();
        $res = $this->get_url_contents($this->api_url.$data_path, '', $this->api_req_params);
        $res = json_decode($res);
        if (isset($res->error)) {
            return "{ error: '$res->error' }";
        } else {
            return $res;
        }
    }

    /**
     * Check if auth tokens exist and we are prepared to make API requests.
     * 
     * @return bool - Returns TRUE if the app is ready to make requests,
     *              or FALSE if user authorization is required
     */
    public function getIsAuthorized()
    {
        return $this->tokens->isAuthorized();
    }

    /**
     * Get link URL for manual user authorization.
     *
     * @return string - The URL for manual user authorization
     */
    public function getAuthLink()
    {
        return $this->auth_link;
    }

    protected function sendApiRequest($url)
    {
        $url = trim($this->api_url.'/'.$url, '/').'/';

        $headers = $this->api_req_params;

        /*
         * I might remove this because it's just being super protective ^.^
         */
        $headers[2] = $this->tokens->makeAuthParam();

        // Working CURL Request
        $response = $this->sendCurlGetRequest($url, $headers);

        dd($response);
    }

    public function sendCurlGetRequest($url, $headers)
    {
        try {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $response = curl_exec($ch);

            if (false === $response) {
                throw new \Exception(curl_error($ch), curl_errno($ch));
            }

            curl_close($ch);
        } catch (\Exception $e) {
            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        }

        return $response;
    }

    public function checkTokens()
    {
        if ($this->tokens->isStale()) {
            $this->refreshToken();
        }
    }
}
