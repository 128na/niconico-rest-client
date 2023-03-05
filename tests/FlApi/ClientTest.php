<?php

declare(strict_types=1);

namespace Tests\FlApi;

use NicoNicoRestClient\FlApi\Client;
use NicoNicoRestClient\FlApi\Video;
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

    public function test()
    {
        $response = $this->getSUT()->list('sm9');

        $this->assertEquals(200, $response->getResponse()->getStatusCode());
        $this->assertInstanceOf(Video::class, $response->getVideos()[0]);
    }
}
