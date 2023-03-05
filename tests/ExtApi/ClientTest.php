<?php

declare(strict_types=1);

namespace Tests\ExtApi;

use NicoNicoApi\ExtApi\Client;
use NicoNicoApi\ExtApi\Video;
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
        $id = 'sm9';
        $response = $this->getSUT()->get($id);

        $this->assertEquals(200, $response->getResponse()->getStatusCode());
        $this->assertInstanceOf(Video::class, $response->getVideo());
    }
}
