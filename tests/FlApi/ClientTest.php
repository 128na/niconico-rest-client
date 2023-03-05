<?php

declare(strict_types=1);

namespace Tests\FlApi;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\FlApi\Client;
use NicoNicoRestClient\FlApi\Video;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\MockInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
    public const MOCK_XML = '<?xml version="1.0" encoding="utf-8"?>
    <related_video status="ok">
    <script/>
    <total_count>12</total_count>
    <page_count>1</page_count>
    <data_count>12</data_count>
    <type>recommend</type>
    <video>
    <url>https://www.nicovideo.jp/watch/sm1</url>
    <thumbnail>https://nicovideo.cdn.nimg.jp/thumbnails/1/1</thumbnail>
    <title>dummy title</title>
    <view>111</view>
    <comment>222</comment>
    <mylist>333</mylist>
    <length>60</length>
    <time>946749845</time>
    </video>

    <video>
    </video>
    </related_video>';

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
                'GET', 'https://flapi.nicovideo.jp/api/getrelation?video=sm0'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK_XML);
            }));
        });

        $result = $this->getSUT($m)->list('sm0');

        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertEquals('sm1', $video->getContentId());
        $this->assertEquals('https://www.nicovideo.jp/watch/sm1', $video->getWatchUrl());
        $this->assertEquals('dummy title', $video->getTitle());
        $this->assertEquals(null, $video->getDescription());
        $this->assertEquals(null, $video->getUserId());
        $this->assertEquals(null, $video->getUserNickname());
        $this->assertEquals(null, $video->getUserIconUrl());
        $this->assertEquals('https://nicovideo.cdn.nimg.jp/thumbnails/1/1', $video->getThumbnailUrl());
        $this->assertEquals(null, $video->getThumbType());
        $this->assertEquals(null, $video->getEmbeddable());
        $this->assertEquals(null, $video->getNoLivePlay());
        $this->assertEquals(DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, '2000-01-02T03:04:05+09:00'), $video->getStartTime());
        $this->assertEquals('1:00', $video->getLengthString());
        $this->assertEquals(60, $video->getLengthSeconds());
        $this->assertEquals(null, $video->getMovieType());
        $this->assertEquals(null, $video->getSizeHigh());
        $this->assertEquals(null, $video->getSizeLow());
        $this->assertEquals(111, $video->getViewCounter());
        $this->assertEquals(222, $video->getCommentCounter());
        $this->assertEquals(333, $video->getMylistCounter());
        $this->assertEquals(null, $video->getLikeCounter());
        $this->assertEquals(null, $video->getLastCommentTime());
        $this->assertEquals(null, $video->getLastResBody());
        $this->assertEquals(null, $video->getTagsString());
        $this->assertEquals([], $video->getTagsArray());
        $this->assertEquals(null, $video->getCategoryTagsString());
        $this->assertEquals([], $video->getCategoryTagsArray());
        $this->assertEquals(null, $video->getGenre());
        $this->assertEquals(null, $video->getChannelId());
    }
}
