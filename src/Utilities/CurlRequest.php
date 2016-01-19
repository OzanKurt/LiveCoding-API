<?php

namespace Kurt\LiveCoding\Utilities;

class CurlRequest
{
    /**
     * Default cURL timeout.
     *
     * @var int
     */
    protected $timeout = 5;

    /**
     * cURL resource instance.
     *
     * @var resource
     */
    protected $curlHandler;

    /**
     * CurlRequest constructor.
     */
    public function __construct()
    {
        $this->curlHandler = $this->newCurlHandler();
    }

    /**
     * Create a new cURL handler instance.
     *
     * @return resource
     */
    protected function newCurlHandler()
    {
        return curl_init();
    }

    /**
     * [execute description].
     *
     * @return mixed
     */
    public function execute()
    {
        $response = curl_exec($this->curlHandler);

        return new CurlResponse($response);
    }

    /**
     * [setHeaders description].
     *
     * @param $headers
     *
     * @return $this
     */
    public function setHttpHeaders($headers)
    {
        curl_setopt($this->curlHandler, CURLOPT_HTTPHEADER, $headers);

        return $this;
    }

    /**
     * [setUrl description].
     *
     * @param $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        curl_setopt($this->curlHandler, CURLOPT_URL, $url);

        return $this;
    }

    /**
     * [setReturn description].
     *
     * @param bool $return
     *
     * @return $this
     */
    public function setReturn($return = true)
    {
        curl_setopt($this->curlHandler, CURLOPT_RETURNTRANSFER, $return);

        return $this;
    }

    /**
     * [setTimeout description].
     *
     * @param $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout)
    {
        curl_setopt($this->curlHandler, CURLOPT_CONNECTTIMEOUT, $timeout);

        return $this;
    }

    /**
     * [setQuery description].
     *
     * @param $fields
     *
     * @return $this
     */
    public function setPostFields($fields)
    {
        curl_setopt($this->curlHandler, CURLOPT_POST, true);
        curl_setopt($this->curlHandler, CURLOPT_POSTFIELDS, http_build_query($fields));

        return $this;
    }

}
