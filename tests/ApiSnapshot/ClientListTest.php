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
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Tests\VideoTestCase;

class ClientListTest extends VideoTestCase
{
    private const MOCK_USER = [
        'data' => [
            [
                'lengthSeconds' => 60,
                'viewCounter' => 100,
                'commentCounter' => 200,
                'mylistCounter' => 300,
                'likeCounter' => 400,
                'genre' => "dummy_genre",
                'startTime' => "2000-01-02T03:04:05+09:00",
                'lastCommentTime' => "2001-01-02T03:04:05+09:00",
                'description' => "dummy description",
                'tags' => "tag1 tag2",
                'lastResBody' => "dummy comment",
                'contentId' => "sm0",
                'userId' => 500,
                'title' => "dummy title",
                'channelId' => null,
                'thumbnailUrl' => "https://nicovideo.cdn.nimg.jp/thumbnails/0/0"
            ]
        ],
        'meta' => [
            'id' => '0000000-1111-2222-3333-444444444444',
            'totalCount' => 1000,
            'status' => 200,
        ],
    ];

    private const MOCK_CHANNEL = [
        'data' => [
            [
                'lengthSeconds' => 60,
                'viewCounter' => 100,
                'commentCounter' => 200,
                'mylistCounter' => 300,
                'likeCounter' => 400,
                'genre' => "dummy_genre",
                'startTime' => "2000-01-02T03:04:05+09:00",
                'lastCommentTime' => "2001-01-02T03:04:05+09:00",
                'description' => "dummy description",
                'tags' => "tag1 tag2",
                'lastResBody' => "dummy comment",
                'contentId' => "sm0",
                'userId' => null,
                'title' => "dummy title",
                'channelId' => 600,
                'thumbnailUrl' => "https://nicovideo.cdn.nimg.jp/thumbnails/0/0"
            ]
        ],
        'meta' => [
            'id' => '0000000-1111-2222-3333-444444444444',
            'totalCount' => 1000,
            'status' => 200,
        ],
    ];
    protected ?string $expectOwnerNameUser = null;
    protected ?string $expectOwnerIconUrlUser = null;
    protected ?string $expectOwnerNameChannel = null;
    protected ?string $expectOwnerIconUrlChannel = null;

    private function getSUT($m): Client
    {
        return new Client($m);
    }

    public function testUser()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://api.search.nicovideo.jp/api/v2/snapshot/video/contents/search?q=test&targets=title%2Cdescription%2Ctags&fields=contentId%2Ctitle%2Cdescription%2CuserId%2CchannelId%2CviewCounter%2CmylistCounter%2ClikeCounter%2ClengthSeconds%2CthumbnailUrl%2CstartTime%2ClastResBody%2CcommentCounter%2ClastCommentTime%2CcategoryTags%2Ctags%2Cgenre&_sort=viewCounter&_offset=0&_limit=10&_context=NicoNicoRestClient'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('toArray')->andReturn(self::MOCK_USER);
            }));
        });

        $q = new Query(['q' => 'test']);
        $result = $this->getSUT($m)->list($q);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);
        $this->assertUserFields($video);
    }

    public function testChannel()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://api.search.nicovideo.jp/api/v2/snapshot/video/contents/search?q=test&targets=title%2Cdescription%2Ctags&fields=contentId%2Ctitle%2Cdescription%2CuserId%2CchannelId%2CviewCounter%2CmylistCounter%2ClikeCounter%2ClengthSeconds%2CthumbnailUrl%2CstartTime%2ClastResBody%2CcommentCounter%2ClastCommentTime%2CcategoryTags%2Ctags%2Cgenre&_sort=viewCounter&_offset=0&_limit=10&_context=NicoNicoRestClient'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('toArray')->andReturn(self::MOCK_CHANNEL);
            }));
        });

        $q = new Query(['q' => 'test']);
        $result = $this->getSUT($m)->list($q);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);
        $this->assertChannelFields($video);
    }
}
