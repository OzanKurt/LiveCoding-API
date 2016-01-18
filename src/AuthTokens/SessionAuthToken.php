<?php

namespace Kurt\LiveCoding\AuthTokens;

class SessionAuthToken extends AuthToken
{
    /**
     * [__construct description].
     */
    public function __construct()
    {
        // Todo: Check if we can replace global variable with `filter_input(INPUT_SESSION, 'key')`.
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * [isAuthorized description].
     * 
     * @return bool
     */
    public function isAuthorized()
    {
        return isset($_SESSION['code']);
    }

    /**
     * [getCode description].
     * 
     * @return [type]
     */
    public function getCode()
    {
        return $this->isAuthorized() ? $_SESSION['code'] : null;
    }

    /**
     * [setCode description].
     * 
     * @param [type] $code
     */
    public function setCode($code)
    {
        $_SESSION['code'] = $code;
    }

    /**
     * [getState description].
     * 
     * @return [type] [description]
     */
    public function getState()
    {
        return $_SESSION['state'];
    }

    /**
     * [setState description].
     * 
     * @param [type] $state [description]
     */
    public function setState($state)
    {
        $_SESSION['state'] = $state;
    }

    /**
     * [getScope description].
     * 
     * @return [type] [description]
     */
    public function getScope()
    {
        return $_SESSION['scope'];
    }

    /**
     * [setScope description].
     * 
     * @param [type] $scope [description]
     */
    public function setScope($scope)
    {
        $_SESSION['scope'] = $scope;
    }

    /**
     * [getTokenType description].
     * 
     * @return [type] [description]
     */
    public function getTokenType()
    {
        return $_SESSION['token_type'];
    }

    /**
     * [setTokenType description].
     * 
     * @param [type] $token_type [description]
     */
    public function setTokenType($token_type)
    {
        $_SESSION['token_type'] = $token_type;
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    public function getAccessToken()
    {
        return $_SESSION['access_token'];
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    public function setAccessToken($access_token)
    {
        $_SESSION['access_token'] = $access_token;
    }

    /**
     * [getRefreshToken description].
     * 
     * @return [type] [description]
     */
    public function getRefreshToken()
    {
        return $_SESSION['refresh_token'];
    }

    /**
     * [setRefreshToken description].
     * 
     * @return [type] [description]
     */
    public function setRefreshToken($refresh_token)
    {
        $_SESSION['refresh_token'] = $refresh_token;
    }

    /**
     * [getExpiresIn description].
     * 
     * @return [type] [description]
     */
    public function getExpiresIn()
    {
        return $_SESSION['expires_in'];
    }

    /**
     * [setExpiresIn description].
     * 
     * @return [type] [description]
     */
    public function setExpiresIn($expires_in)
    {
        $_SESSION['expires_in'] = $expires_in;
    }
}
