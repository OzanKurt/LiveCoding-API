<?php

namespace Kurt\LiveCoding\AuthTokens;

/**
 * @class AuthToken
 * AuthToken is intended to be semi-abstract
 * Only it's subclasses should be instantiated
 */
abstract class AuthToken
{
    /**
     * Store token data to subclass defined backend.
     **/
    public function storeTokens($tokens)
    {
        $tokens = json_decode($tokens);

        if (!isset($tokens->error)) {
            $this->setAccessToken($tokens->access_token);
            $this->setTokenType($tokens->token_type);
            $this->setRefreshToken($tokens->refresh_token);
            $this->setExpiresIn(date('Y-m-d H:i:s', (time() + $tokens->expires_in)));
            $this->setScope($tokens->scope);
        }
    }

    /**
     * Determine if our access token needs to be refreshed.
     *
     * @return bool
     */
    public function isStale()
    {
        return (strtotime($this->getExpiresIn()) - time()) < 7200;
    }

    /**
     * Concatenate current auth token to param string for data request.
     **/
    public function makeAuthParam()
    {
        return 'Authorization: '.$this->getTokenType().' '.$this->getAccessToken();
    }

    /**
     * Subclasses should override these getters and setters.
     */

    /**
     * [isAuthorized description].
     * 
     * @return bool [description]
     */
    abstract public function isAuthorized();

    /**
     * [getCode description].
     * 
     * @return [type] [description]
     */
    abstract public function getCode();

    /**
     * [setCode description].
     * 
     * @param [type] $code [description]
     */
    abstract public function setCode($code);

    /**
     * [getState description].
     * 
     * @return [type] [description]
     */
    abstract public function getState();

    /**
     * [setState description].
     * 
     * @return [type] [description]
     */
    abstract public function setState($state);

    /**
     * [getAccessToken description].
     * 
     * @return [type] [description]
     */
    abstract public function getAccessToken();

    /**
     * [setAccessToken description].
     * 
     * @return [type] [description]
     */
    abstract public function setAccessToken($access_token);

    /**
     * [getTokenType description].
     * 
     * @return [type] [description]
     */
    abstract public function getTokenType();

    /**
     * [setTokenType description].
     * 
     * @return [type] [description]
     */
    abstract public function setTokenType($token_type);

    /**
     * [getRefreshToken description].
     * 
     * @return [type] [description]
     */
    abstract public function getRefreshToken();

    /**
     * [setRefreshToken description].
     * 
     * @return [type] [description]
     */
    abstract public function setRefreshToken($refresh_token);

    /**
     * [getExpiresIn description].
     * 
     * @return [type] [description]
     */
    abstract public function getExpiresIn();

    /**
     * [setExpiresIn description].
     * 
     * @return [type] [description]
     */
    abstract public function setExpiresIn($expires_in);

    /**
     * [getScope description].
     * 
     * @return [type] [description]
     */
    abstract public function getScope();

    /**
     * [setScope description].
     * 
     * @return [type] [description]
     */
    abstract public function setScope($scope);
}
