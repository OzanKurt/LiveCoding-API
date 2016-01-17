<?php

namespace Kurt\LiveCoding;

trait HelperMethods
{
    public function codingCategories($name = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("codingcategories/{$name}");
    }

    public function languages($name = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("languages/{$name}");
    }

    public function livestreams($username = null)
    {
        $this->checkTokens();

        return $this->sendApiRequest("livestreams/{$username}");
    }

    public function livestreamsOnAir()
    {
        $this->checkTokens();

        return $this->sendApiRequest('livestreams/onair');
    }

    public function user()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user');
    }

    public function userFollowers()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/followers');
    }

    public function userFollows()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/follows');
    }

    public function userViewingKey()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/viewing_key');
    }

    public function userChatAccount()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/chat/account');
    }

    public function userLivestreams()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/livestreams');
    }

    public function userLivestreamsOnAir()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/livestreams/onair');
    }

    public function userVideos()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/videos');
    }

    public function userVideosLatest()
    {
        $this->checkTokens();

        return $this->sendApiRequest('user/videos/latest');
    }

    public function users($username = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("users/{$username}");
    }

    public function videos($slug = '')
    {
        $this->checkTokens();

        return $this->sendApiRequest("videos/{$slug}");
    }
}
