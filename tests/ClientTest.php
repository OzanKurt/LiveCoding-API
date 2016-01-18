<?php

use Kurt\LiveCoding\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        @session_start();

        $this->client = new Client([
            'id'          => '5844713178',
            'secret'      => '88481424978152416071',
            'redirectUrl' => 'http://localhost:8000/index.php',
        ]);
    }

    /** @test */
    public function it_does_something()
    {
        //
    }
}
