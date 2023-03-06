<?php

declare(strict_types=1);

namespace Tests\ApiExt;

use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\ApiExt\Client;
use NicoNicoRestClient\ApiExt\Video;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Tests\VideoTestCase;

class ClientGetTest extends VideoTestCase
{
    private const MOCK_USER_XML = '<?xml version="1.0" encoding="utf-8"?>
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
    <size_high>2000</size_high>
    <size_low>1000</size_low>
    <view_counter>100</view_counter>
    <comment_num>200</comment_num>
    <mylist_counter>300</mylist_counter>
    <last_res_body>dummy comment</last_res_body>
    <watch_url>https://www.nicovideo.jp/watch/sm0</watch_url>
    <thumb_type>video</thumb_type>
    <embeddable>1</embeddable>
    <no_live_play>0</no_live_play>
    <tags domain="jp">
    <tag lock="1">tag1</tag>
    <tag>tag2</tag>
    </tags>
    <genre>dummy_genre</genre>
    <user_id>500</user_id>
    <user_nickname>dummy user name</user_nickname>
    <user_icon_url>https://example.com/user</user_icon_url>
    </thumb>
    </nicovideo_thumb_response>';

    private const MOCK_CHANNEL_XML = '<?xml version="1.0" encoding="utf-8"?>
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
    <size_high>2000</size_high>
    <size_low>1000</size_low>
    <view_counter>100</view_counter>
    <comment_num>200</comment_num>
    <mylist_counter>300</mylist_counter>
    <last_res_body>dummy comment</last_res_body>
    <watch_url>https://www.nicovideo.jp/watch/sm0</watch_url>
    <thumb_type>video</thumb_type>
    <embeddable>1</embeddable>
    <no_live_play>0</no_live_play>
    <tags domain="jp">
    <tag lock="1">tag1</tag>
    <tag>tag2</tag>
    </tags>
    <genre>dummy_genre</genre>
    <ch_id>600</ch_id>
    <ch_name>dummy channel name</ch_name>
    <ch_icon_url>https://example.com/channel</ch_icon_url>
    </thumb>
    </nicovideo_thumb_response>';

    protected ?int $expectLikeCounter = null;
    protected ?string $expectLastCommentTime = null;

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
                'GET', 'https://ext.nicovideo.jp/api/getthumbinfo/sm0'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK_USER_XML);
            }));
        });

        $id = 'sm0';
        $result = $this->getSUT($m)->get($id);
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
                'GET', 'https://ext.nicovideo.jp/api/getthumbinfo/sm0'
            ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
                $m->allows('getStatusCode')->andReturn(200);
                $m->allows('getContent')->andReturn(self::MOCK_CHANNEL_XML);
            }));
        });

        $id = 'sm0';
        $result = $this->getSUT($m)->get($id);
        $this->assertEquals(200, $result->getResponse()->getStatusCode());

        $video = $result->getVideo();
        $this->assertInstanceOf(Video::class, $video);

        $this->assertCommonFields($video);
        $this->assertChannelFields($video);
        $this->assertExtraFields($video);
    }

    private function assertExtraFields(Video $video): void
    {
        $this->assertEquals('video', $video->getThumbType());
        $this->assertEquals(true, $video->getEmbeddable());
        $this->assertEquals(false, $video->getNoLivePlay());
        $this->assertEquals('flv', $video->getMovieType());
        $this->assertEquals(2000, $video->getSizeHigh());
        $this->assertEquals(1000, $video->getSizeLow());
    }
}
