<?php

declare(strict_types=1);

namespace Tests\Rss;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\Rss\Client;
use NicoNicoRestClient\Rss\Video;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\Rss\Result;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
    public const MOCK_XML = '<?xml version="1.0" encoding="utf-8"?>
    <feed xmlns="http://www.w3.org/2005/Atom" xml:lang="ja" xmlns:media="http://search.yahoo.com/mrss/">
      <title>dummy rss title</title>
      <subtitle>dummy rss subtitle</subtitle>
      <link rel="alternate" type="text/html" href="https://www.nicovideo.jp/user/1/video"/>
      <link rel="self" type="application/atom+xml" href="https://www.nicovideo.jp/user/1/video?rss=atom"/>
      <id>https://www.nicovideo.jp/user/1/video</id>
      <updated>2000-01-02T03:04:05+09:00</updated>
      <author>
        <name>dummy user</name>
      </author>
      <generator uri="https://www.nicovideo.jp">ニコニコ動画</generator>
      <rights>(c) DWANGO Co., Ltd.</rights>
      <entry>
        <title>dummy title</title>
        <link rel="alternate" type="text/html" href="https://www.nicovideo.jp/watch/sm0?ref=rss_myvideo_atom"/>
        <id>tag:nicovideo.jp,2000-01-02:/watch/sm0</id>
        <published>2000-01-02T03:04:05+09:00</published>
        <updated>2000-01-02T03:04:05+09:00</updated>
        <content type="html"><![CDATA[
            <p>dummy html</p>
        ]]></content>
        <media:title>dummy title</media:title>
        <media:thumbnail url="https://nicovideo.cdn.nimg.jp/thumbnails/0/0.0"/>
      </entry>
      <entry>
      </entry>
      </feed>';

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function getSUT($m): Client
    {
        return new Client($m);
    }

    public function testUser()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://www.nicovideo.jp/user/1/video?rss=atom&page=1'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK_XML);
            }));
        });

        $result = $this->getSUT($m)->user(1);
        $this->assertResult($result);
    }

    public function testUserMylist()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://www.nicovideo.jp/user/1/mylist/2?rss=atom&page=1'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK_XML);
            }));
        });

        $result = $this->getSUT($m)->userMylist(1, 2);
        $this->assertResult($result);
    }

    public function testMylist()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://www.nicovideo.jp/mylist/2?rss=atom&page=1'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK_XML);
            }));
        });

        $result = $this->getSUT($m)->mylist(2);
        $this->assertResult($result);
    }

    private function assertResult(Result $result): void
    {
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        /** @var Video */
        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertEquals('sm0', $video->getContentId());
        $this->assertEquals('https://www.nicovideo.jp/watch/sm0?ref=rss_myvideo_atom', $video->getWatchUrl());
        $this->assertEquals('dummy title', $video->getTitle());
        $this->assertEquals('dummy html', $video->getDescription());
        $this->assertEquals('<p>dummy html</p>', $video->getDescriptionHtml());
        $this->assertEquals(null, $video->getUserId());
        $this->assertEquals(null, $video->getUserNickname());
        $this->assertEquals(null, $video->getUserIconUrl());
        $this->assertEquals('https://nicovideo.cdn.nimg.jp/thumbnails/0/0.0', $video->getThumbnailUrl());
        $this->assertEquals(null, $video->getThumbType());
        $this->assertEquals(null, $video->getEmbeddable());
        $this->assertEquals(null, $video->getNoLivePlay());
        $this->assertEquals(DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, '2000-01-02T03:04:05+09:00'), $video->getStartTime());
        $this->assertEquals(null, $video->getLengthString());
        $this->assertEquals(null, $video->getLengthSeconds());
        $this->assertEquals(null, $video->getMovieType());
        $this->assertEquals(null, $video->getSizeHigh());
        $this->assertEquals(null, $video->getSizeLow());
        $this->assertEquals(null, $video->getViewCounter());
        $this->assertEquals(null, $video->getCommentCounter());
        $this->assertEquals(null, $video->getMylistCounter());
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
