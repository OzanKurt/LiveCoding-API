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
     *
     * @return void
     */
    public function setCode($code)
    {
        $_SESSION['code'] = $code;
    }

    /**
     * [getState description].
     * 
     * @return [type]
     */
    public function getState()
    {
        return $_SESSION['state'];
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
        $_SESSION['state'] = $state;
    }

    /**
     * [getScope description].
     * 
     * @return [type]
     */
    public function getScope()
    {
        return $_SESSION['scope'];
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
        $_SESSION['scope'] = $scope;
    }

    /**
     * [getTokenType description].
     * 
     * @return [type]
     */
    public function getTokenType()
    {
        return $_SESSION['token_type'];
    }

    /**
     * [setTokenType description].
     * 
     * @param [type] $token_type
     *
     * @return void
     */
    public function setTokenType($tokenType)
    {
        $_SESSION['token_type'] = $tokenType;
    }

    /**
     * [getAccessToken description].
     * 
     * @return [type]
     */
    public function getAccessToken()
    {
        return $_SESSION['access_token'];
    }

    /**
     * [getAccessToken description].
     *
     * @param [type] $accessToken
     *
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $_SESSION['access_token'] = $accessToken;
    }

    /**
     * [getRefreshToken description].
     * 
     * @return [type]
     */
    public function getRefreshToken()
    {
        return $_SESSION['refresh_token'];
    }

    /**
     * [setRefreshToken description].
     *
     * @param [type] $refreshToken
     *
     * @return void
     */
    public function setRefreshToken($refreshToken)
    {
        $_SESSION['refresh_token'] = $refreshToken;
    }

    /**
     * [getExpiresIn description].
     * 
     * @return [type]
     */
    public function getExpiresIn()
    {
        return $_SESSION['expires_in'];
    }

    /**
     * [setExpiresIn description].
     *
     * @param [type] $expiresIn
     *
     * @return void
     */
    public function setExpiresIn($expiresIn)
    {
        $_SESSION['expires_in'] = $expiresIn;
    }
}
