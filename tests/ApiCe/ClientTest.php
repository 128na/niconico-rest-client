<?php

declare(strict_types=1);

namespace Tests\ApiCe;

use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\ApiCe\Client;
use NicoNicoRestClient\ApiCe\User;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
    public const MOCK_ARRAY = [
        'niconico_response' => [
            '@status' => 'ok',
            'user' => [
                'id' => '1',
                'nickname' => 'dummy user name',
                'thumbnail_url' => 'http://example.com'
            ]
        ]
    ];

    private function getSUT($m): Client
    {
        return new Client($m);
    }

    public function testUserInfo()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://api.ce.nicovideo.jp/api/v1/user.info?__format=json&user_id=1'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('toArray')->andReturn(self::MOCK_ARRAY);
            }));
        });

        $result = $this->getSUT($m)->userInfo(1);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $user = $result->getUser();
        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('dummy user name', $user->getNickname());
        $this->assertEquals('http://example.com', $user->getThumbnailUrl());
    }
}
