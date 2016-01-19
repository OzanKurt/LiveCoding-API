<?php

use Kurt\LiveCoding\Client;
use Kurt\LiveCoding\LiveCoding;

/**
 * Class ClientTest
 */
class ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * Client instance.
     *
     * @var Client
     */
    protected $client;

    /**
     * LiveCoding instance.
     *
     * @var LiveCoding
     */
    protected $liveCoding;

    /**
     * Start the session and instantiate variables.
     */
    public function setUp()
    {
        @session_start();

        $this->client = new Client([
            'id'          => '5844713178',
            'secret'      => '88481424978152416071',
            'redirectUrl' => 'http://localhost:8000/index.php',
        ]);

        $this->liveCoding = new LiveCoding($this->client);
    }

    /** @test */
    public function it_generates_authentication_link()
    {
        $authLink = $this->liveCoding->getAuthLink();

        if (!$this->liveCoding->isAuthorized()) {
            $this->assertContains(
                $this->client->getId(),
                $authLink
            );

            $this->assertContains(
                urlencode($this->client->getRedirectUrl()),
                $authLink
            );
        }
    }
}
