<?php

use Kurt\LiveCoding\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client([
            'id'          => '12631243816253178',
            'secret'      => '123465129834629',
            'redirectUrl' => 'http://localhost:8000/index.php',
            'scope'       => new Kurt\LiveCoding\Scopes\ReadScope(),
        ]);
    }

    /** @test */
    public function it_does_something()
    {
        $this->assertTrue(true);
    }
}
