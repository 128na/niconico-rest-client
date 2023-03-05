<?php

declare(strict_types=1);

namespace Tests\SnapshotApi;

use NicoNicoApi\SnapshotApi\Client;
use NicoNicoApi\SnapshotApi\Query;
use NicoNicoApi\SnapshotApi\Video;
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
        $q = new Query(['q' => 'test']);
        $response = $this->getSUT()->list($q);

        $this->assertEquals(200, $response->getResponse()->getStatusCode());
        $this->assertInstanceOf(Video::class, $response->getVideos()[0]);
    }
}
