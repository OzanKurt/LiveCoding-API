<?php

namespace Kurt\LiveCoding\AuthTokens;

/**
 * Class AuthToken
 * @package Kurt\LiveCoding\AuthTokens
 */
abstract class AuthToken
{

    /**
     * Store token data to subclass defined backend.
     *
     * @param $tokens
     */
    public function storeTokens($tokens)
    {
        $tokens = json_decode($tokens);

        if (!isset($tokens->error)) {
            $this->setVariables($tokens);
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
     * @param $state
     *
     * @return  [type] [description]
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
     * @param $accessToken
     *
     * @return  [type] [description]
     */
    abstract public function setAccessToken($accessToken);

    /**
     * [getTokenType description].
     *
     * @return [type] [description]
     */
    abstract public function getTokenType();

    /**
     * [setTokenType description].
     *
     * @param $tokenType
     *
     * @return  [type] [description]
     */
    abstract public function setTokenType($tokenType);

    /**
     * [getRefreshToken description].
     *
     * @return [type] [description]
     */
    abstract public function getRefreshToken();

    /**
     * [setRefreshToken description].
     *
     * @param $refreshToken
     *
     * @return  [type] [description]
     */
    abstract public function setRefreshToken($refreshToken);

    /**
     * [getExpiresIn description].
     *
     * @return [type] [description]
     */
    abstract public function getExpiresIn();

    /**
     * [setExpiresIn description].
     *
     * @param $expiresIn
     *
     * @return  [type] [description]
     */
    abstract public function setExpiresIn($expiresIn);

    /**
     * [getScope description].
     *
     * @return [type] [description]
     */
    abstract public function getScope();

    /**
     * [setScope description].
     *
     * @param $scope
     *
     * @return  [type] [description]
     */
    abstract public function setScope($scope);

    /**
     * Set the variables from tokens.
     *
     * @param $tokens
     */
    protected function setVariables($tokens)
    {
        $this->setAccessToken(
            $tokens->access_token
        );

        $this->setExpiresIn(
            date('Y-m-d H:i:s', (time() + $tokens->expires_in))
        );

        $this->setRefreshToken(
            $tokens->refresh_token
        );

        $this->setScope(
            $tokens->scope
        );

        $this->setTokenType(
            $tokens->token_type
        );
    }
}
