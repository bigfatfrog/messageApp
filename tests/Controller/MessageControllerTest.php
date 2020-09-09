<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('POST', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/message');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('POST', '/message');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
