<?php

declare(strict_types=1);

namespace Tests\ApiSnapshot;

use DateTimeImmutable;
use DateTimeInterface;
use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\ApiSnapshot\Client;
use NicoNicoRestClient\ApiSnapshot\Query;
use NicoNicoRestClient\ApiSnapshot\Video;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
    public const MOCK_ARRAY = [
        'data' => [
            [
                'lengthSeconds' => 60,
                'categoryTags' => "cat_tag1 cat_tag2",
                'viewCounter' => 111,
                'commentCounter' => 222,
                'mylistCounter' => 333,
                'likeCounter' => 444,
                'genre' => "ジャンル１",
                'startTime' => "2000-01-02T03:04:05+09:00",
                'lastCommentTime' => "2001-01-02T03:04:05+09:00",
                'description' => "dummy description",
                'tags' => "tag1 tag2",
                'lastResBody' => "dummy comment",
                'contentId' => "sm0",
                'userId' => 999,
                'title' => "dummy title",
                'channelId' => 123,
                'thumbnailUrl' => "https://nicovideo.cdn.nimg.jp/thumbnails/0/0"
            ]
        ],
        'meta' => [
            'id' => '0000000-1111-2222-3333-444444444444',
            'totalCount' => 1000,
            'status' => 200,
        ],
    ];

    private function getSUT($m): Client
    {
        return new Client($m);
    }

    public function test()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://api.search.nicovideo.jp/api/v2/snapshot/video/contents/search?q=test&targets=title%2Cdescription%2Ctags&fields=contentId%2Ctitle%2Cdescription%2CuserId%2CchannelId%2CviewCounter%2CmylistCounter%2ClikeCounter%2ClengthSeconds%2CthumbnailUrl%2CstartTime%2ClastResBody%2CcommentCounter%2ClastCommentTime%2CcategoryTags%2Ctags%2Cgenre&_sort=viewCounter&_offset=0&_limit=10&_context=NicoNicoRestClient'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('toArray')->andReturn(self::MOCK_ARRAY);
            }));
        });

        $q = new Query(['q' => 'test']);
        $result = $this->getSUT($m)->list($q);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertEquals('sm0', $video->getContentId());
        $this->assertEquals('https://www.nicovideo.jp/watch/sm0', $video->getWatchUrl());
        $this->assertEquals('dummy title', $video->getTitle());
        $this->assertEquals('dummy description', $video->getDescription());
        $this->assertEquals(999, $video->getUserId());
        $this->assertEquals(null, $video->getUserNickname());
        $this->assertEquals(null, $video->getUserIconUrl());
        $this->assertEquals('https://nicovideo.cdn.nimg.jp/thumbnails/0/0', $video->getThumbnailUrl());
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
        $this->assertEquals(444, $video->getLikeCounter());
        $this->assertEquals(DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, '2001-01-02T03:04:05+09:00'), $video->getLastCommentTime());
        $this->assertEquals('dummy comment', $video->getLastResBody());
        $this->assertEquals('tag1 tag2', $video->getTagsString());
        $this->assertEquals(['tag1', 'tag2'], $video->getTagsArray());
        $this->assertEquals('cat_tag1 cat_tag2', $video->getCategoryTagsString());
        $this->assertEquals(['cat_tag1', 'cat_tag2'], $video->getCategoryTagsArray());
        $this->assertEquals('ジャンル１', $video->getGenre());
        $this->assertEquals(123, $video->getChannelId());
    }
}
