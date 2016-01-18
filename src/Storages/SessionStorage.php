<?php

namespace Kurt\LiveCoding\Storages;

use Kurt\LiveCoding\AuthTokens\SessionAuthToken;

class SessionStorage extends Storage
{
    /**
     * [__construct description].
     */
    public function __construct()
    {
        $this->initializeAuthToken();
    }

    /**
     * Initialize AuthToken instance related to the storage.
     * 
     * @return void
     */
    protected function initializeAuthToken()
    {
        $this->authToken = new SessionAuthToken();
    }
}
