<?php

namespace Kurt\LiveCoding\Utilities\Curl;

class Response
{

    /**
     * @var string
     */
    protected $string;

    /**
     * CurlResponse constructor.
     *
     * @param string $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * [toArray description].
     *
     * @return mixed
     */
    public function toArray()
    {
        return $this->decode();
    }

    /**
     * [toObject description].
     *
     * @return mixed
     */
    public function toObject()
    {
        return $this->decode();
    }

    /**
     * [decode description].
     *
     * @param bool $toArray
     *
     * @return mixed
     */
    private function decode($toArray = true)
    {
        return json_decode($this->string, $toArray);
    }

    /**
     * [__toString description].
     *
     * @return string
     */
    function __toString()
    {
        return $this->string;
    }

}