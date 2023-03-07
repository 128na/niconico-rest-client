<?php

declare(strict_types=1);

namespace Tests\Unit\ApiCe;

use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\ApiCe\Client;
use NicoNicoRestClient\ApiCe\Video;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Tests\Unit\VideoTestCase;

class ClientVideoInfoTest extends VideoTestCase
{
    private const MOCK_USER = [
        'niconico_response' => [
            '@status' => 'ok',
            'tags' => [
                'tag_info' => [
                    [
                        'tag' => 'tag1',
                        'area' => 'jp'
                    ],
                    [
                        'tag' => 'tag2',
                        'area' => 'jp'
                    ],
                ]
            ],
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
                'genre' => [
                    'key' => '',
                    'label' => 'dummy_genre'
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

    private const MOCK_CHANNEL = [
        'niconico_response' => [
            '@status' => 'ok',
            'tags' => [
                'tag_info' => [
                    [
                        'tag' => 'tag1',
                        'area' => 'jp'
                    ],
                    [
                        'tag' => 'tag2',
                        'area' => 'jp'
                    ],
                ]
            ],
            'thread' => [
                'id' => '1000',
                'num_res' => '200',
                'summary' => '',
                'group_type' => 'default'
            ],
            'video' => [
                'id' => 'sm0',
                'user_id' => '0',
                'deleted' => '0',
                'title' => 'dummy title',
                'description' => 'dummy description',
                'length_in_seconds' => '60',
                'thumbnail_url' => 'http://nicovideo.cdn.nimg.jp/thumbnails/0/0',   // httpsではない
                'first_retrieve' => '2000-01-02T03:04:05+09:00',
                'default_thread' => '',
                'view_counter' => '100',
                'mylist_counter' => '300',
                'genre' => [
                    'key' => '',
                    'label' => 'dummy_genre'
                ],
                'option_flag_community' => '1',
                'community_id' => 'ch600',
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

    protected ?string $expectThumbnailUrl = 'http://nicovideo.cdn.nimg.jp/thumbnails/0/0';
    protected ?int $expectLikeCounter = null;
    protected ?string $expectLastCommentTime = null;
    protected ?string $expectLastResBody = null;
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
                'GET', 'https://api.ce.nicovideo.jp/nicoapi/v1/video.info?__format=json&v=sm0'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('toArray')->andReturn(self::MOCK_USER);
            }));
        });

        $result = $this->getSUT($m)->videoInfo('sm0');
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideo();
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);
        $this->assertUserFields($video);
        $this->assertExtraFields($video);
    }

    public function testChannel()
    {
        $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
            $m->shouldReceive('request')->withArgs([
                'GET', 'https://api.ce.nicovideo.jp/nicoapi/v1/video.info?__format=json&v=sm0'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('toArray')->andReturn(self::MOCK_CHANNEL);
            }));
        });

        $result = $this->getSUT($m)->videoInfo('sm0');
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideo();
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);
        $this->assertChannelFields($video);
        $this->assertExtraFields($video);
    }

    private function assertExtraFields(Video $video): void
    {
        $this->assertEquals(false, $video->getDeleted());
    }
}
