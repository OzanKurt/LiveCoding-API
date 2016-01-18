<?php

namespace Kurt\LiveCoding\AuthTokens;

use Kurt\LiveCoding\Utilities\FileManager;

class FileAuthToken extends AuthToken
{
    /**
     * [$fileManager description].
     * 
     * @var [type]
     */
    protected $fileManager;

    /**
     * [__construct description].
     */
    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * [isAuthorized description].
     * 
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->fileManager->exists('code');
    }

    /**
     * [getCode description].
     * 
     * @return [type]
     */
    public function getCode()
    {
        return $this->fileManager->exists('code') ? $this->fileManager->get('code') : null;
    }

    /**
     * [setCode description].
     * 
     * @param [type] $code
     *
     * @return void
     */
    public function setCode($code)
    {
        $this->fileManager->put('code', $code);
    }

    /**
     * [getState description].
     * 
     * @return [type]
     */
    public function getState()
    {
        return $this->fileManager->get('state');
    }

    /**
     * [setState description].
     * 
     * @param [type] $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->fileManager->put('state', $state);
    }

    /**
     * [getScope description].
     * 
     * @return [type]
     */
    public function getScope()
    {
        return $this->fileManager->get('scope');
    }

    /**
     * [setScope description].
     * 
     * @param [type] $scope
     *
     * @return void
     */
    public function setScope($scope)
    {
        $this->fileManager->put('scope', $scope);
    }

    /**
     * [getTokenType description].
     * 
     * @return [type]
     */
    public function getTokenType()
    {
        return $this->fileManager->get('tokenType');
    }

    /**
     * [setTokenType description].
     * 
     * @param [type] $tokenType
     *
     * @return void
     */
    public function setTokenType($tokenType)
    {
        $this->fileManager->put('tokenType', $tokenType);
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type]
     */
    public function getAccessToken()
    {
        return $this->fileManager->get('access_token');
    }

    /**
     * [getAccessToken description].
     * 
     * @param [type] $accessToken
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->fileManager->put('access_token', $accessToken);
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type]
     */
    public function getRefreshToken()
    {
        return $this->fileManager->get('refresh_token');
    }

    /**
     * [getAccessToken description].
     *
     * @param [type] $refreshToken
     * @return void
     */
    public function setRefreshToken($refreshToken)
    {
        $this->fileManager->put('refresh_token', $refreshToken);
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type]
     */
    public function getExpiresIn()
    {
        return $this->fileManager->get('expires_in');
    }

    /**
     * [getAccessToken description].
     *
     * @param [type] $expiresIn
     * @return void
     */
    public function setExpiresIn($expiresIn)
    {
        $this->fileManager->put('expires_in', $expiresIn);
    }
}
