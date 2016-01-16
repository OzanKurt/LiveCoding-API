<?php

namespace Kurt\LiveCoding\AuthTokens;

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
    public function __construct()
    {
        $this->fileManager = new FileManager();
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
        return $this->fileManager->get('code');
    }

    /**
     * [setCode description].
     * 
     * @param [type] $code
     */
    public function setCode($code)
    {
        $this->fileManager->put('code', $code);
    }

    /**
     * [getState description].
     * 
     * @return [type] [description]
     */
    public function getState()
    {
        return $this->fileManager->get('state');
    }

    /**
     * [setState description].
     * 
     * @param [type] $state [description]
     */
    public function setState($state)
    {
        $this->fileManager->put('state', $state);
    }

    /**
     * [getScope description].
     * 
     * @return [type] [description]
     */
    public function getScope()
    {
        return $this->fileManager->get('scope');
    }

    /**
     * [setScope description].
     * 
     * @param [type] $scope [description]
     */
    public function setScope($scope)
    {
        $this->fileManager->put('scope', $scope);
    }

    /**
     * [getTokenType description].
     * 
     * @return [type] [description]
     */
    public function getTokenType()
    {
        return $this->fileManager->get('token_type');
    }

    /**
     * [setTokenType description].
     * 
     * @param [type] $token_type [description]
     */
    public function setTokenType($token_type)
    {
        $this->fileManager->put('token_type', $token_type);
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    public function getAccessToken()
    {
        return $this->fileManager->get('access_token');
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    public function setAccessToken($access_token)
    {
        $this->fileManager->put('access_token', $access_token);
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    public function getRefreshToken()
    {
        return $this->fileManager->get('refresh_token');
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    public function setRefreshToken($refresh_token)
    {
        $this->fileManager->put('refresh_token', $refresh_token);
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    public function getExpiresIn()
    {
        return $this->fileManager->get('expires_in');
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    public function setExpiresIn($expires_in)
    {
        $this->fileManager->put('expires_in', $expires_in);
    }
}
