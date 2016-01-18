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

    /**
     * [$state description]
     * 
     * @var string
     */
    protected $state;

    /**
     * [$authLink description].
     * 
     * @var string
     */
    protected $authLink;

    /**
     * [$authToken description]
     * 
     * @var Kurt\LiveCoding\AuthTokens\AuthToken
     */
    protected $authToken;

    /**
     * Base API url of LiveCodingTV.
     * 
     * @var string
     */
    protected $apiUrl = 'https://www.livecoding.tv:443/api';

    /**
     * Base oAuth token url of LiveCodingTV.
     * 
     * @var string
     */
    protected $tokenUrl = 'https://www.livecoding.tv/o/token/';

    /**
     * [$apiRequiredParams description].
     * 
     * @var array
     */
    protected $apiRequiredParams;

    /**
     * [$tokenRequiredParams description].
     * 
     * @var array
     */
    protected $tokenRequiredParams;

    /**
     * [$tokenRequiredHeaders description].
     * 
     * @var array
     */
    protected $tokenRequiredHeaders;

    public function __construct($client)
    {
        $this->client = $client;

        $this->state = uniqid();

        $this->initializeAuthToken();

        $this->initializeAuthLink();

        $this->tokenRequiredHeaders = [
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'Authorization: Basic '.base64_encode($this->client->getId().':'.$this->client->getSecret()),
        ];

        $this->tokenRequiredParams = [
            'grant_type'   => '',
            'code'         => $this->authToken->getCode(),
            'redirect_uri' => $this->client->getRedirectUrl(),
        ];

        $this->apiRequiredParams = [
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'Authorization: TOKEN_TYPE_DEFERRED ACCESS_TOKEN_DEFERRED',
        ];

        // Check the storage for existing tokens
        if ($this->authToken->isAuthorized()) {
            // Here we are authorized from a previous request
            // Nothing to do - yay
        } elseif (isset($_GET['state']) && $_GET['state'] == $this->authToken->getState()) {
            // Here we are returning from user auth approval link
            $this->fetchTokens($_GET['code']);
        } else {
            // Here we have not yet been authorized
            // Save the state before displaying auth link
            $this->authToken->setState($this->state);
        }
    }

    /**
     * [initializeAuthToken description].
     * 
     * @return void
     */
    public function initializeAuthToken()
    {
        $this->authToken = $this->client->getStorage()->getAuthToken();

        // if ($this->client->usesFileStorage()) {
        //     $fileStorage = $this->client->getStorage();
        //     $fileManager = new FileManager($fileStorage->getPath());
        //     $this->authToken = new FileAuthToken($fileManager);
        // } elseif ($this->client->usesSessionStorage()) {
        //     $this->authToken = new SessionAuthToken();
        // } else {
        //     throw new \Exception('Storage type is not valid.');
        // }
    }

    /**
     * [initializeAuthLink description].
     * 
     * @return void
     */
    public function initializeAuthLink()
    {
        $query = [
            'scope'         => $this->client->getScope()->getText(),
            'state'         => $this->state,
            'redirect_uri'  => $this->client->getRedirectUrl(),
            'client_id'     => $this->client->getId(),
            'response_type' => 'code',
        ];

        $this->authLink = 'https://www.livecoding.tv/o/authorize/?'.http_build_query($query);
    }

    /**
     * [fetchTokens description].
     * 
     * @param string $code
     *
     * @return void
     */
    private function fetchTokens($code)
    {
        $this->authToken->setCode($code);
        $this->tokenRequiredParams['code'] = $code;
        $this->tokenRequiredParams['grant_type'] = 'authorization_code';

        $res = $this->post_url_contents($this->tokenUrl, $this->tokenRequiredParams, $this->tokenRequiredHeaders);
        // Store access tokens
        $this->authToken->storeTokens($res);
    }

    private function post_url_contents($url, $query, $headers = [])
    {
        $query['client_id'] = $this->client->getId();

        try {
            $curl = curl_init();
            $timeout = 5;

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, count($query));
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($query));

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
            $response = curl_exec($curl);

            if (false === $response) {
                throw new \Exception(curl_error($curl), curl_errno($curl));
            }

            curl_close($curl);
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
        $this->tokenRequiredParams['grant_type'] = 'refresh_token';
        $this->tokenRequiredParams['refresh_token'] = $this->authToken->getRefreshToken();
        $res = $this->post_url_contents($this->tokenUrl, $this->tokenRequiredParams, $this->tokenRequiredHeaders);
        // Store access tokens
        $this->authToken->storeTokens($res);
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
        $this->apiRequiredParams[2] = $this->authToken->makeAuthParam();
        $res = $this->get_url_contents($this->apiUrl.$data_path, '', $this->apiRequiredParams);
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
        return $this->authToken->isAuthorized();
    }

    /**
     * Get link URL for manual user authorization.
     *
     * @return string - The URL for manual user authorization
     */
    public function getAuthLink()
    {
        return $this->authLink;
    }

    protected function sendApiRequest($url)
    {
        $url = trim($this->apiUrl.'/'.$url, '/').'/';

        $headers = $this->apiRequiredParams;

        /*
         * I might remove this because it's just being super protective ^.^
         */
        $headers[2] = $this->authToken->makeAuthParam();

        // Working CURL Request
        $response = $this->sendCurlGetRequest($url, $headers);

        dd($response);
    }

    public function sendCurlGetRequest($url, $headers)
    {
        try {
            $curl = curl_init();
            $timeout = 5;
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
            $response = curl_exec($curl);

            if (false === $response) {
                throw new \Exception(curl_error($curl), curl_errno($curl));
            }

            curl_close($curl);
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
        if ($this->authToken->isStale()) {
            $this->refreshToken();
        }
    }
}
