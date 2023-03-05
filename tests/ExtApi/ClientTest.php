<?php

declare(strict_types=1);

namespace Tests\ExtApi;

use DateTimeImmutable;
use DateTimeInterface;
use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\ExtApi\Client;
use NicoNicoRestClient\ExtApi\Video;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
    public const MOCK_XML = '<?xml version="1.0" encoding="utf-8"?>
    <nicovideo_thumb_response status="ok">
    <script/>
    <thumb>
    <video_id>sm0</video_id>
    <title>dummy title</title>
    <description>dummy description</description>
    <thumbnail_url>https://nicovideo.cdn.nimg.jp/thumbnails/0/0</thumbnail_url>
    <first_retrieve>2000-01-02T03:04:05+09:00</first_retrieve>
    <length>1:00</length>
    <movie_type>flv</movie_type>
    <size_high>20000</size_high>
    <size_low>10000</size_low>
    <view_counter>111</view_counter>
    <comment_num>222</comment_num>
    <mylist_counter>333</mylist_counter>
    <last_res_body>dummy comment</last_res_body>
    <watch_url>https://www.nicovideo.jp/watch/sm0</watch_url>
    <thumb_type>video</thumb_type>
    <embeddable>1</embeddable>
    <no_live_play>0</no_live_play>
    <tags domain="jp">
    <tag lock="1">lock_tag</tag>
    <tag>normal_tag</tag>
    </tags>
    <genre>未設定</genre>
    <user_id>999</user_id>
    <user_nickname>dummy user name</user_nickname>
    <user_icon_url>https://example.com</user_icon_url>
    </thumb>
    </nicovideo_thumb_response>';

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function getSUT($m): Client
    {
        return new Client($m);
    }

    public function test()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://ext.nicovideo.jp/api/getthumbinfo/sm0'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK_XML);
            }));
        });

        $id = 'sm0';
        $result = $this->getSUT($m)->get($id);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideo();
        $this->assertInstanceOf(Video::class, $video);

        $this->assertEquals('sm0', $video->getContentId());
        $this->assertEquals('https://www.nicovideo.jp/watch/sm0', $video->getWatchUrl());
        $this->assertEquals('dummy title', $video->getTitle());
        $this->assertEquals('dummy description', $video->getDescription());
        $this->assertEquals(999, $video->getUserId());
        $this->assertEquals('dummy user name', $video->getUserNickname());
        $this->assertEquals('https://example.com', $video->getUserIconUrl());
        $this->assertEquals('https://nicovideo.cdn.nimg.jp/thumbnails/0/0', $video->getThumbnailUrl());
        $this->assertEquals('video', $video->getThumbType());
        $this->assertEquals(true, $video->getEmbeddable());
        $this->assertEquals(false, $video->getNoLivePlay());
        $this->assertEquals(DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, '2000-01-02T03:04:05+09:00'), $video->getStartTime());
        $this->assertEquals('1:00', $video->getLengthString());
        $this->assertEquals(60, $video->getLengthSeconds());
        $this->assertEquals('flv', $video->getMovieType());
        $this->assertEquals(20000, $video->getSizeHigh());
        $this->assertEquals(10000, $video->getSizeLow());
        $this->assertEquals(111, $video->getViewCounter());
        $this->assertEquals(222, $video->getCommentCounter());
        $this->assertEquals(333, $video->getMylistCounter());
        $this->assertEquals(null, $video->getLikeCounter());
        $this->assertEquals(null, $video->getLastCommentTime());
        $this->assertEquals('dummy comment', $video->getLastResBody());
        $this->assertEquals('lock_tag normal_tag', $video->getTagsString());
        $this->assertEquals(['lock_tag', 'normal_tag'], $video->getTagsArray());
        $this->assertEquals(null, $video->getCategoryTagsString());
        $this->assertEquals([], $video->getCategoryTagsArray());
        $this->assertEquals('未設定', $video->getGenre());
        $this->assertEquals(null, $video->getChannelId());
    }
}
