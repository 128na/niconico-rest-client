<?php

declare(strict_types=1);

namespace Tests;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\Base\Video;
use PHPUnit\Framework\TestCase;

abstract class VideoTestCase extends TestCase
{
    protected ?string $expectContentId = 'sm0';
    protected ?string $expectWatchUrl = 'https://www.nicovideo.jp/watch/sm0';
    protected ?string $expectTitle = 'dummy title';
    protected ?string $expectDescription = 'dummy description';
    protected ?string $expectThumbnailUrl = 'https://nicovideo.cdn.nimg.jp/thumbnails/0/0';
    protected ?string $expectStartTime = '2000-01-02T03:04:05+09:00';
    protected ?string $expectLengthString = '1:00';
    protected ?int $expectLengthSeconds = 60;
    protected ?int $expectViewCounter = 100;
    protected ?int $expectCommentCounter = 200;
    protected ?int $expectMylistCounter = 300;
    protected ?int $expectLikeCounter = 400;
    protected ?string $expectLastCommentTime = '2001-01-02T03:04:05+09:00';
    protected ?string $expectLastResBody = 'dummy comment';
    protected array $expectTags = ['tag1', 'tag2'];
    protected ?string $expectGenre = 'dummy_genre';

    protected ?string $expectOwnerTypeUser = Video::OWNER_TYPE_USER;
    protected ?int $expectOwnerIdUser = 500;
    protected ?string $expectOwnerNameUser = 'dummy user name';
    protected ?string $expectOwnerIconUrlUser = 'https://example.com/user';

    protected ?string $expectOwnerTypeChannel = Video::OWNER_TYPE_CHANNEL;
    protected ?int $expectOwnerIdChannel = 600;
    protected ?string $expectOwnerNameChannel = 'dummy channel name';
    protected ?string $expectOwnerIconUrlChannel = 'https://example.com/channel';

    protected function assertCommonFields(Video $video): void
    {
        $this->assertEquals($this->expectContentId, $video->getContentId(), 'ContentId');
        $this->assertEquals($this->expectWatchUrl, $video->getWatchUrl(), 'WatchUrl');
        $this->assertEquals($this->expectTitle, $video->getTitle(), 'Title');
        $this->assertEquals($this->expectDescription, $video->getDescription(), 'Description');
        $this->assertEquals($this->expectThumbnailUrl, $video->getThumbnailUrl(), 'ThumbnailUrl');
        $this->assertEquals(
            is_null($this->expectStartTime)
                ? null
                : DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $this->expectStartTime),
            $video->getStartTime(),
            'StartTime'
        );
        $this->assertEquals($this->expectLengthString, $video->getLengthString(), 'LengthString');
        $this->assertEquals($this->expectLengthSeconds, $video->getLengthSeconds(), 'LengthSeconds');
        $this->assertEquals($this->expectViewCounter, $video->getViewCounter(), 'ViewCounter');
        $this->assertEquals($this->expectCommentCounter, $video->getCommentCounter(), 'CommentCounter');
        $this->assertEquals($this->expectMylistCounter, $video->getMylistCounter(), 'MylistCounter');
        $this->assertEquals($this->expectLikeCounter, $video->getLikeCounter(), 'LikeCounter');
        $this->assertEquals(
            is_null($this->expectLastCommentTime)
                ? null
                : DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $this->expectLastCommentTime),
            $video->getLastCommentTime(),
            'LastCommentTime'
        );
        $this->assertEquals($this->expectLastResBody, $video->getLastResBody(), 'LastResBody');
        $this->assertEquals($this->expectTags, $video->getTags(), 'Tags');
        $this->assertEquals($this->expectGenre, $video->getGenre(), 'Genre');
    }

    protected function assertUserFields(Video $video): void
    {
        $this->assertEquals($this->expectOwnerTypeUser, $video->getOwnerType(), 'OwnerTypeUser');
        $this->assertEquals($this->expectOwnerIdUser, $video->getOwnerId(), 'OwnerIdUser');
        $this->assertEquals($this->expectOwnerNameUser, $video->getOwnerName(), 'OwnerNameUser');
        $this->assertEquals($this->expectOwnerIconUrlUser, $video->getOwnerIconUrl(), 'OwnerIconUrlUser');
    }

    protected function assertChannelFields(Video $video): void
    {
        $this->assertEquals($this->expectOwnerTypeChannel, $video->getOwnerType(), 'OwnerTypeChannel');
        $this->assertEquals($this->expectOwnerIdChannel, $video->getOwnerId(), 'OwnerIdChannel');
        $this->assertEquals($this->expectOwnerNameChannel, $video->getOwnerName(), 'OwnerNameChannel');
        $this->assertEquals($this->expectOwnerIconUrlChannel, $video->getOwnerIconUrl(), 'OwnerIconUrlChannel');
    }
}
