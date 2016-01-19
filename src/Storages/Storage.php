<?php

namespace Kurt\LiveCoding\Storages;

/**
 * Class Storage
 * @package Kurt\LiveCoding\Storages
 */
abstract class Storage
{
    /**
     * AuthToken instance of the storage.
     *
     * @var \Kurt\LiveCoding\AuthTokens\AuthToken
     */
    protected $authToken;

    /**
     * String representation of the storage.
     *
     * @var string
     */
    protected $text;

    /**
     * AuthToken instance related to the storage.
     *
     * @return \Kurt\LiveCoding\AuthTokens\AuthToken
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * Get the string representation of the storage.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Initialize AuthToken instance related to the storage.
     *
     * @return void
     */
    abstract protected function initializeAuthToken();

    /**
     * [isFileStorage description].
     *
     * @return bool
     */
    public function isFileStorage()
    {
        return $this instanceof FileStorage;
    }

    /**
     * [isSessionStorage description].
     *
     * @return bool
     */
    public function isSessionStorage()
    {
        return $this instanceof SessionStorage;
    }
}
