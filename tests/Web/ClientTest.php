<?php

declare(strict_types=1);

namespace Tests\Web;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\Web\Client;
use NicoNicoRestClient\Web\Video;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\MockInterface;
use NicoNicoRestClient\Web\Result;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
  private const MOCK_USER_HTML = '<!DOCTYPE HTML>
    <html lang="ja">
    <head>
      <meta charset="utf-8" />
      <title>dummy series title - ニコニコ</title>
      <meta property="og:title" content="dummy series title - ニコニコ">
      <meta name="twitter:title" content="dummy series title - ニコニコ">
      <meta name="description" content="dummy series description">
      <meta property="og:description" content="dummy series description">
      <meta name="twitter:description" content="dummy series description">
      <meta property="og:url" content="https://sp.nicovideo.jp/series/1">
      <meta property="og:image" content="https://dcdn.cdn.nimg.jp/nicovideo/series/tmb/0/999/1.2">
      <meta name="twitter:image" content="https://dcdn.cdn.nimg.jp/nicovideo/series/tmb/0/999/1.2">
      <link rel="canonical" href="https://www.nicovideo.jp/user/999/series/1" />
    </head>
    <body class="hdNoFixed isAndroid">
      <div class="series-Header_Container">
        <div class="series-Header_Title">
          <div class="series-Header_Icon">
            <div class="siteWide-SVGIcon siteWide-SeriesIcon"></div>
          </div>
          <h2 class="series-Header_TitleText">
            dummy series title </h2>
          <div class="series-Header_Menu">
            <span class="siteWide-SVGIcon siteWide-MenuIcon"></span>
          </div>
        </div>
        <div class="series-Header_Owner">
          <div class="siteWide-Owner">
            <div class="siteWide-Owner_Icon">
              <a href="https://sp.nicovideo.jp/user/999">
                <img alt="" class="jsLazyImage jsLazyImageTarget "
                  data-original="https://secure-dcdn.cdn.nimg.jp/nicoaccount/usericon/s/83/999.jpg?123">
              </a>
            </div>
            <div class="siteWide-Owner_Name">
              <a class="siteWide-Owner_Link" href="https://sp.nicovideo.jp/user/999">
                dummy user name
              </a>
            </div>
          </div>
        </div>
        <div class="series-Header_Description">
          <div class="ExpandableText" data-initialized="false" data-collapsed-height="0" data-expandable="true"
            data-expanded="false">
            <div class="ExpandableText-inner">
              <div class="ExpandableText-expandedText">dummy series description</div>
              <div class="ExpandableText-collapsedText">dummy series description</div>
              <div class="ExpandableText-expander">
                <span class="ExpandableText-expandLabel">もっと見る</span>
                <span class="ExpandableText-collapseLabel">閉じる</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="jsSeriesToolbarContainer">
        <div class="siteWide-Toolbar"></div>
      </div>
      <section id="jsVideoList" class="series-VideoList_Container">
        <ul class="video-list">
          <li class="video-list-item list-table" data-watch_id="sm0" data-video_id="sm0"
            data-title="dummy video title" data-owner_type="user" data-owner_id="999" data-owner_name="dummy user name"
            data-owner_url="https://sp.nicovideo.jp/user/999"
            data-owner_icon_url="http://example/com/user"
            data-video_length="60" data-comment_counter="222" data-like_counter="444" data-mylist_counter="333"
            data-view_counter="111" data-live_start_time="" data-_12345678="false" data-is_muted="false"
            data-video_url="https://sp.nicovideo.jp/watch/sm0?ref=series">
            <div class="video-item-container ">
              <a class="video-item-area" href="https://sp.nicovideo.jp/watch/sm0?ref=series">
                <div class="video-thumbnail-container">
                  <span class="video-item-time">5:22</span>
                  <img alt="" class="jsLazyImage jsLazyImageTarget video-item-thumbnail" data-original="http://example.com/vi">
                  <div class="mask">
                    <span class="siteWide-SVGIcon siteWide-TvChanSilhouetteIcon"></span>
                  </div>>
                </div>
                <div class="video-information-container">
                  <div class="video-information-inner">
                    <p class="video-item-title">
                      dummy video title
                    </p>
                    <div class="video-information-attributes">
                      <p class="video-item-date-label">
                        <span class="video-item-date">2000/1/2</span>
                      </p>
                      <ul class="video-item-metaData">
                        <li class="video-item-metaData-view"><span class="count">111</span></li>
                        <li class="video-item-metaData-comment"><span class="count">222</span></li>
                        <li class="video-item-metaData-like"><span class="count">444</span></li>
                        <li class="video-item-metaData-mylist"><span class="count">333</span></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </li>
        </ul>
      </section>
    </body>
    </html>';

  private const MOCK_CHANNEL_HTML = '<!DOCTYPE HTML>
    <html lang="ja">
    <head>
      <meta charset="utf-8" />
      <title>dummy series title - ニコニコ</title>
      <meta property="og:title" content="dummy series title - ニコニコ">
      <meta name="twitter:title" content="dummy series title - ニコニコ">
      <meta name="description" content="dummy series description">
      <meta property="og:description" content="dummy series description">
      <meta name="twitter:description" content="dummy series description">
      <meta property="og:url" content="https://sp.nicovideo.jp/series/1">
      <meta property="og:image" content="https://dcdn.cdn.nimg.jp/nicovideo/series/tmb/0/999/1.2">
      <meta name="twitter:image" content="https://dcdn.cdn.nimg.jp/nicovideo/series/tmb/0/999/1.2">
      <link rel="canonical" href="https://www.nicovideo.jp/user/999/series/1" />
    </head>
    <body class="hdNoFixed isAndroid">
      <div class="series-Header_Container">
        <div class="series-Header_Title">
          <div class="series-Header_Icon">
            <div class="siteWide-SVGIcon siteWide-SeriesIcon"></div>
          </div>
          <h2 class="series-Header_TitleText">
            dummy series title </h2>
          <div class="series-Header_Menu">
            <span class="siteWide-SVGIcon siteWide-MenuIcon"></span>
          </div>
        </div>
        <div class="series-Header_Owner">
          <div class="siteWide-Owner">
            <div class="siteWide-Owner_Icon">
              <a href="https://sp.nicovideo.jp/user/999">
                <img alt="" class="jsLazyImage jsLazyImageTarget "
                  data-original="https://secure-dcdn.cdn.nimg.jp/nicoaccount/usericon/s/83/999.jpg?123">
              </a>
            </div>
            <div class="siteWide-Owner_Name">
              <a class="siteWide-Owner_Link" href="https://sp.nicovideo.jp/user/999">
                dummy user name
              </a>
            </div>
          </div>
        </div>
        <div class="series-Header_Description">
          <div class="ExpandableText" data-initialized="false" data-collapsed-height="0" data-expandable="true"
            data-expanded="false">
            <div class="ExpandableText-inner">
              <div class="ExpandableText-expandedText">dummy series description</div>
              <div class="ExpandableText-collapsedText">dummy series description</div>
              <div class="ExpandableText-expander">
                <span class="ExpandableText-expandLabel">もっと見る</span>
                <span class="ExpandableText-collapseLabel">閉じる</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="jsSeriesToolbarContainer">
        <div class="siteWide-Toolbar"></div>
      </div>
      <section id="jsVideoList" class="series-VideoList_Container">
        <ul class="video-list">
          <li class="video-list-item list-table" data-watch_id="sm0" data-video_id="sm0"
            data-title="dummy video title" data-owner_type="channel" data-owner_id="ch999" data-owner_name="dummy channel name"
            data-owner_url="https://sp.ch.nicovideo.jp/info/ch999"
            data-owner_icon_url="http://example/com/ch"
            data-video_length="60" data-comment_counter="222" data-like_counter="444" data-mylist_counter="333"
            data-view_counter="111" data-live_start_time="" data-_12345678="false" data-is_muted="false"
            data-video_url="https://sp.nicovideo.jp/watch/sm0?ref=series">
            <div class="video-item-container ">
              <a class="video-item-area" href="https://sp.nicovideo.jp/watch/sm0?ref=series">
                <div class="video-thumbnail-container">
                  <span class="video-item-time">5:22</span>
                  <img alt="" class="jsLazyImage jsLazyImageTarget video-item-thumbnail" data-original="http://example.com/vi">
                  <div class="mask">
                    <span class="siteWide-SVGIcon siteWide-TvChanSilhouetteIcon"></span>
                  </div>>
                </div>
                <div class="video-information-container">
                  <div class="video-information-inner">
                    <p class="video-item-title">
                      dummy video title
                    </p>
                    <div class="video-information-attributes">
                      <p class="video-item-date-label">
                        <span class="video-item-date">2000/1/2</span>
                      </p>
                      <ul class="video-item-metaData">
                        <li class="video-item-metaData-view"><span class="count">111</span></li>
                        <li class="video-item-metaData-comment"><span class="count">222</span></li>
                        <li class="video-item-metaData-like"><span class="count">444</span></li>
                        <li class="video-item-metaData-mylist"><span class="count">333</span></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </li>
        </ul>
      </section>
    </body>
    </html>';

  protected function setUp(): void
  {
    parent::setUp();
  }

  private function getSUT($m): Client
  {
    return new Client($m);
  }

  public function testSeries()
  {
    $m = Mockery::mock(HttpClientInterface::class, function (MockInterface $m) {
      $m->shouldReceive('request')->withArgs([
        'GET', 'https://sp.nicovideo.jp/series/1'
      ])->andReturn(Mockery::mock(ResponseInterface::class, function (MockInterface $m) {
        $m->allows('getStatusCode')->andReturn(200);
        $m->allows('getContent')->andReturn(self::MOCK_USER_HTML);
      }));
    });

    $result = $this->getSUT($m)->series(1);

    $this->assertEquals(200, $result->getResponse()->getStatusCode());

    $video = $result->getVideos()[0];
    $this->assertInstanceOf(Video::class, $video);

    $this->assertEquals('sm0', $video->getContentId());
    $this->assertEquals('https://www.nicovideo.jp/watch/sm0', $video->getWatchUrl());
    $this->assertEquals('dummy title', $video->getTitle());
    $this->assertEquals('dummy description', $video->getDescription());
    $this->assertEquals(999, $video->getUserId());
    $this->assertEquals('https://nicovideo.cdn.nimg.jp/thumbnails/0/0', $video->getThumbnailUrl());
    $this->assertEquals(DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, '2000-01-02T03:04:05+09:00'), $video->getStartTime());
    $this->assertEquals('1:00', $video->getLengthString());
    $this->assertEquals(60, $video->getLengthSeconds());
    $this->assertEquals(111, $video->getViewCounter());
    $this->assertEquals(222, $video->getCommentCounter());
    $this->assertEquals(333, $video->getMylistCounter());
    $this->assertEquals(null, $video->getLikeCounter());
    $this->assertEquals(null, $video->getLastCommentTime());
    $this->assertEquals('dummy comment', $video->getLastResBody());
    $this->assertEquals(['lock_tag', 'normal_tag'], $video->getTags());
    $this->assertEquals('未設定', $video->getGenre());
    $this->assertEquals(null, $video->getChannelId());
    //  extra fields
    $this->assertEquals('video', $video->getThumbType());
    $this->assertEquals(true, $video->getEmbeddable());
    $this->assertEquals(false, $video->getNoLivePlay());
    $this->assertEquals('dummy user name', $video->getUserNickname());
    $this->assertEquals('https://example.com/user', $video->getUserIconUrl());
    $this->assertEquals('flv', $video->getMovieType());
    $this->assertEquals(20000, $video->getSizeHigh());
    $this->assertEquals(10000, $video->getSizeLow());
  }
}
