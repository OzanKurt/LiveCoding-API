<?php

namespace Kurt\LiveCoding;

use Kurt\LiveCoding\Utilities\Curl\Request as CurlRequest;

/**
 * Class LiveCoding
 * @package Kurt\LiveCoding
 */
class LiveCoding
{
    use HelperMethods;

    /**
     * LiveCodingTV client instance.
     *
     * @var \Kurt\LiveCoding\Client
     */
    protected $client;

    /**
     * [$state description].
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
     * [$authToken description].
     *
     * @var \Kurt\LiveCoding\AuthTokens\AuthToken
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

    /**
     * LiveCoding constructor.
     *
     * @param $client
     */
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

        $response = $this->postUrlContents($this->tokenUrl, $this->tokenRequiredParams, $this->tokenRequiredHeaders);

        // Store access tokens
        $this->authToken->storeTokens($response);
    }

    /**
     * [postUrlContents description].
     *
     * @param       $url
     * @param       $query
     * @param array $headers
     *
     * @return mixed|null
     */
    private function postUrlContents($url, $query, $headers = [])
    {
        $query['client_id'] = $this->client->getId();

        $response = null;

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
    }

    /**
     * Refresh stale tokens.
     *
     * @return void
     */
    private function refreshToken()
    {
        $this->tokenRequiredParams['grant_type'] = 'refresh_token';
        $this->tokenRequiredParams['refresh_token'] = $this->authToken->getRefreshToken();
        $response = $this->postUrlContents($this->tokenUrl, $this->tokenRequiredParams, $this->tokenRequiredHeaders);

        // Store access tokens
        $this->authToken->storeTokens($response);
    }

    /**
     * Check if auth tokens exist and we are prepared to make API requests.
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->authToken->isAuthorized();
    }

    /**
     * Get link URL for manual user authorization.
     *
     * @return string
     */
    public function getAuthLink()
    {
        return $this->authLink;
    }

    /**
     * [sendApiRequest description].
     *
     * @param string $url
     *
     * @return array
     */
    protected function sendApiRequest($url)
    {
        $url = $this->trimUrlForApiRequest($url);

        $headers = $this->getHeadersForApiRequest();

        return $this->sendCurlGetRequest($url, $headers);
    }

    /**
     * [sendCurlGetRequest description].
     *
     * @param $url
     * @param $headers
     *
     * @return mixed
     */
    protected function sendCurlGetRequest($url, $headers)
    {
        $curlRequest = new CurlRequest();

        $curlRequest
            ->setHttpHeaders($headers)
            ->setUrl($url)
            ->setReturn(true)
            ->setTimeout(5);

        return $curlRequest->execute();
    }

    /**
     * [checkTokens description].
     *
     * @return void
     */
    public function checkTokens()
    {
        if ($this->authToken->isStale()) {
            $this->refreshToken();
        }
    }

    /**
     * [getHeadersForApiRequest description].
     *
     * @return array
     */
    private function getHeadersForApiRequest()
    {
        $headers = $this->apiRequiredParams;

        /**
         * Todo: I might remove this because it's just being super protective ^.^
         */
        $headers[2] = $this->authToken->makeAuthParam();

        return $headers;
    }

    /**
     * [trimUrlForApiRequest description].
     *
     * @param $url
     *
     * @return string
     */
    private function trimUrlForApiRequest($url)
    {
        return trim(implode('/', [
            $this->apiUrl,
            $url
        ]), '/').'/';
    }
}
