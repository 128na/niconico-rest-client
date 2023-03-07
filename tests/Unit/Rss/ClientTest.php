<?php

declare(strict_types=1);

namespace Tests\Unit\Rss;

use NicoNicoRestClient\Rss\Client;
use NicoNicoRestClient\Rss\Video;
use Mockery;
use Mockery\MockInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Tests\Unit\VideoTestCase;

class ClientTest extends VideoTestCase
{
    private const MOCK = '<?xml version="1.0" encoding="utf-8"?>
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
            <p>dummy description</p>
        ]]></content>
        <media:title>dummy title</media:title>
        <media:thumbnail url="https://nicovideo.cdn.nimg.jp/thumbnails/0/0.0"/>
      </entry>
      <entry>
      </entry>
      </feed>';

    protected ?string $expectWatchUrl = 'https://www.nicovideo.jp/watch/sm0?ref=rss_myvideo_atom';
    protected ?string $expectThumbnailUrl = 'https://nicovideo.cdn.nimg.jp/thumbnails/0/0.0';
    protected ?string $expectLengthString = null;
    protected ?int $expectLengthSeconds = null;
    protected ?int $expectViewCounter = null;
    protected ?int $expectCommentCounter = null;
    protected ?int $expectMylistCounter = null;
    protected ?int $expectLikeCounter = null;
    protected ?string $expectLastCommentTime = null;
    protected ?string $expectLastResBody = null;
    protected array $expectTags = [];
    protected ?string $expectGenre = null;

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
                $m->allows('getContent')->andReturn(self::MOCK);
            }));
        });

        $result = $this->getSUT($m)->user(1);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        /** @var Video */
        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);

        $this->assertExtraFields($video);
    }

    public function testUserMylist()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://www.nicovideo.jp/user/1/mylist/2?rss=atom&page=1'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK);
            }));
        });

        $result = $this->getSUT($m)->userMylist(1, 2);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        /** @var Video */
        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);

        $this->assertExtraFields($video);
    }

    public function testMylist()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://www.nicovideo.jp/mylist/2?rss=atom&page=1'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK);
            }));
        });

        $result = $this->getSUT($m)->mylist(2);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        /** @var Video */
        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);

        $this->assertExtraFields($video);
    }

    private function assertExtraFields(Video $video): void
    {
        $this->assertEquals('<p>dummy description</p>', $video->getDescriptionHtml());
    }
}
