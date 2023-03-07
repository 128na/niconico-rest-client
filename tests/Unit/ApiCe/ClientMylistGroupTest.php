<?php

declare(strict_types=1);

namespace Tests\Unit\ApiCe;

use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\ApiCe\Client;
use NicoNicoRestClient\ApiCe\Mylist;
use NicoNicoRestClient\ApiCe\User;
use NicoNicoRestClient\ApiCe\Video;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Tests\Unit\VideoTestCase;

class ClientMylistGroupTest extends VideoTestCase
{
    private const MOCK = [
        'niconico_response' => [
            '@status' => 'ok',
            'mylistgroup' => [
                [
                    'id' => '1000',
                    'user_id' => '1100',
                    'name' => 'dummy mylist title',
                    'description' => 'dummy mylist description',
                    'public' => '1',
                    'default_sort' => '1',
                    'default_sort_method' => 'a',
                    'default_sort_order' => 'd',
                    'count' => '1200',
                    'video_info' => [
                        [
                            'thread' => [
                                'id' => '1000',
                                'num_res' => '200',
                                'summary' => '',
                                'group_type' => 'default'
                            ],
                            'video' => [
                                'id' => 'sm0',
                                'user_id' => '500',
                                'deleted' => '0',
                                'title' => 'dummy title',
                                'description' => 'dummy description',
                                'length_in_seconds' => '60',
                                'thumbnail_url' => 'http://nicovideo.cdn.nimg.jp/thumbnails/0/0',   // httpsではない
                                'first_retrieve' => '2000-01-02T03:04:05+09:00',
                                'default_thread' => '',
                                'view_counter' => '100',
                                'mylist_counter' => '300',
                                'option_flag_community' => '0',
                                'community_id' => '',
                                'vita_playable' => '',
                                'ppv_video' => '0',
                                'provider_type' => 'regular',
                                'options' => [
                                    '@sun' => '0',
                                    '@large_thumbnail' => '',
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    protected ?string $expectThumbnailUrl = 'http://nicovideo.cdn.nimg.jp/thumbnails/0/0';
    protected ?int $expectLikeCounter = null;
    protected array $expectTags = [];
    protected ?string $expectLastCommentTime = null;
    protected ?string $expectLastResBody = null;
    protected ?string $expectOwnerNameUser = null;
    protected ?string $expectOwnerIconUrlUser = null;
    protected ?string $expectOwnerNameChannel = null;
    protected ?string $expectOwnerIconUrlChannel = null;
    protected ?string $expectGenre = null;

    private function getSUT($m): Client
    {
        return new Client($m);
    }

    public function testMylistGroup()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://api.ce.nicovideo.jp/nicoapi/v1/mylistgroup.get?__format=json&group_id=1&detail=1'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('toArray')->andReturn(self::MOCK);
            }));
        });

        $result = $this->getSUT($m)->mylistGroup(1);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $mylist = $result->getMylist();
        $this->assertInstanceOf(Mylist::class, $mylist);

        $this->assertMylistFields($mylist);

        /** @var Video */
        $video = $result->getVideos()[0];
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);
        $this->assertUserFields($video);
        $this->assertExtraFields($video);
    }

    private function assertMylistFields(Mylist $mylist): void
    {
        $this->assertEquals(1000, $mylist->getId());
        $this->assertEquals(1100, $mylist->getUserId());
        $this->assertEquals('dummy mylist title', $mylist->getName());
        $this->assertEquals('dummy mylist description', $mylist->getDescription());
        $this->assertEquals(true, $mylist->getPublic());
        $this->assertEquals(true, $mylist->getDefaultSort());
        $this->assertEquals('a', $mylist->getDefaultSortMethod());
        $this->assertEquals('d', $mylist->getDefaultSortOrder());
        $this->assertEquals(1200, $mylist->getCount());
    }

    private function assertExtraFields(Video $video): void
    {
        $this->assertEquals(false, $video->getDeleted());
    }
}
