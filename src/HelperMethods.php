<?php

namespace Kurt\LiveCoding;

/**
 * Class HelperMethods
 * @package Kurt\LiveCoding
 */
trait HelperMethods
{

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function codingCategories($name = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("codingcategories/{$name}");
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function languages($name = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("languages/{$name}");
    }

    /**
     * @param string $username
     *
     * @return mixed
     */
    public function livestreams($username = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("livestreams/{$username}");
    }

    /**
     * @return mixed
     */
    public function livestreamsOnAir()
    {
        $this->checkTokens();

        return $this->sendApiRequest('livestreams/onair');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user');
    }

    /**
     * @return mixed
     */
    public function userFollowers()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/followers');
    }

    /**
     * @return mixed
     */
    public function userFollows()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/follows');
    }

    /**
     * @return mixed
     */
    public function userViewingKey()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/viewing_key');
    }

    /**
     * @return mixed
     */
    public function userChatAccount()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/chat/account');
    }

    /**
     * @return mixed
     */
    public function userLivestreams()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/livestreams');
    }

    /**
     * @return mixed
     */
    public function userLivestreamsOnAir()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/livestreams/onair');
    }

    /**
     * @return mixed
     */
    public function userVideos()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/videos');
    }

    /**
     * @return mixed
     */
    public function userVideosLatest()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/videos/latest');
    }

    /**
     * @param string $username
     *
     * @return mixed
     */
    public function users($username = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("users/{$username}");
    }

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function videos($slug = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("videos/{$slug}");
    }
}
