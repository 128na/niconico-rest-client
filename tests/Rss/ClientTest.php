<?php

declare(strict_types=1);

namespace Tests\Rss;

use NicoNicoApi\Rss\Client;
use NicoNicoApi\Rss\Video;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

class ClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    private function getSUT(): Client
    {
        return new Client(HttpClient::create());
    }

    public function testUserMylist()
    {
        $response = $this->getSUT()->userMylist(830813, 4788840);

        $this->assertEquals(200, $response->getResponse()->getStatusCode());
        $this->assertInstanceOf(Video::class, $response->getVideos()[0]);
    }
    public function testUser()
    {
        $response = $this->getSUT()->user(830813);

        $this->assertEquals(200, $response->getResponse()->getStatusCode());
        $this->assertInstanceOf(Video::class, $response->getVideos()[0]);
    }
    public function testMylist()
    {
        $response = $this->getSUT()->mylist(4788840);

        $this->assertEquals(200, $response->getResponse()->getStatusCode());
        $this->assertInstanceOf(Video::class, $response->getVideos()[0]);
    }
}
