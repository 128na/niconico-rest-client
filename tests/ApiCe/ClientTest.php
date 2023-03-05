<?php

declare(strict_types=1);

namespace Tests\ApiCe;

use DateTimeImmutable;
use DateTimeInterface;
use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\ApiCe\Client;
use NicoNicoRestClient\ApiCe\User;
use NicoNicoRestClient\ApiCe\Video;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
    public const MOCK_USER = [
        'niconico_response' => [
            '@status' => 'ok',
            'user' => [
                'id' => '1',
                'nickname' => 'dummy user name',
                'thumbnail_url' => 'http://example.com'
            ]
        ]
    ];

    public const MOCK_VIDEO = [
        'niconico_response' => [
            '@status' => 'ok',
            'tags' => [
                'tag_info' => [
                    [
                        'tag' => 'dummy_tag',
                        'area' => 'jp'
                    ],
                ]
            ],
            'thread' => [
                'id' => '1111',
                'num_res' => '222',
                'summary' => '',
                'group_type' => 'default'
            ],
            'video' => [
                'id' => 'sm0',
                'user_id' => '1',
                'deleted' => '0',
                'title' => 'dummy title',
                'description' => 'dummy description',
                'length_in_seconds' => '60',
                'thumbnail_url' => 'http://nicovideo.cdn.nimg.jp/thumbnails/0/0',   // httpsではない
                'first_retrieve' => '2000-01-02T03:04:05+09:00',
                'default_thread' => '',
                'view_counter' => '111',
                'mylist_counter' => '333',
                'genre' => [
                    'key' => '',
                    'label' => '未設定'
                ],
                'option_flag_community' => '0',
                'community_id' => '',
                'vita_playable' => '',
                'ppv_video' => '0',
                'provider_type' => 'regular',
                'options' => [
                    '@sun' => '0',
                    '@large_thumbnail' => '',
                    '@adult' => '0'
                ]
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
                $m->allows('toArray')->andReturn(self::MOCK_USER);
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

    public function testVideoInfo()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://api.ce.nicovideo.jp/nicoapi/v1/video.info?__format=json&v=sm0'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('toArray')->andReturn(self::MOCK_VIDEO);
            }));
        });

        $result = $this->getSUT($m)->videoInfo('sm0');
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideo();
        $this->assertInstanceOf(Video::class, $video);

        $this->assertEquals('sm0', $video->getContentId());
        $this->assertEquals('https://www.nicovideo.jp/watch/sm0', $video->getWatchUrl());
        $this->assertEquals('dummy title', $video->getTitle());
        $this->assertEquals('dummy description', $video->getDescription());
        $this->assertEquals(1, $video->getUserId());
        $this->assertEquals('http://nicovideo.cdn.nimg.jp/thumbnails/0/0', $video->getThumbnailUrl());
        $this->assertEquals(DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, '2000-01-02T03:04:05+09:00'), $video->getStartTime());
        $this->assertEquals('1:00', $video->getLengthString());
        $this->assertEquals(60, $video->getLengthSeconds());
        $this->assertEquals(111, $video->getViewCounter());
        $this->assertEquals(222, $video->getCommentCounter());
        $this->assertEquals(333, $video->getMylistCounter());
        $this->assertEquals(null, $video->getLikeCounter());
        $this->assertEquals(null, $video->getLastCommentTime());
        $this->assertEquals(null, $video->getLastResBody());
        $this->assertEquals(['dummy_tag'], $video->getTags());
        $this->assertEquals([], $video->getCategoryTags());
        $this->assertEquals('未設定', $video->getGenre());
        $this->assertEquals(null, $video->getChannelId());
        //  extra fields
        $this->assertEquals(false, $video->getDeleted());
        $this->assertEquals('', $video->getCommunityId());
    }
}
