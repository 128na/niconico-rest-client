<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiSnapshot;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\Base\Video as BaseVideo;
use NicoNicoRestClient\Helper\Functions;

class Video extends BaseVideo
{
    public function getContentId(): ?string
    {
        return $this->item['contentId'] ?? null;
    }

    public function getWatchUrl(): ?string
    {
        return $this->getContentId()
            ? sprintf('https://www.nicovideo.jp/watch/%s', $this->getContentId())
            : null;
    }

    public function getTitle(): ?string
    {
        return $this->item['title'] ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->item['description'] ?? null;
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->item['thumbnailUrl'] ?? null;
    }

    public function getStartTime(): ?DateTimeImmutable
    {
        $str = $this->item['startTime'] ?? null;
        return $str
            ? DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $str)
            : null;
    }

    public function getLengthString(): ?string
    {
        return is_null($this->getLengthSeconds())
            ? null
            : Functions::secondsToTimeString($this->getLengthSeconds());
    }

    public function getLengthSeconds(): ?int
    {
        return $this->item['lengthSeconds'] ?? null;
    }

    public function getViewCounter(): ?int
    {
        return $this->item['viewCounter'] ?? null;
    }

    public function getCommentCounter(): ?int
    {
        return $this->item['commentCounter'] ?? null;
    }

    public function getMylistCounter(): ?int
    {
        return $this->item['mylistCounter'] ?? null;
    }

    public function getLikeCounter(): ?int
    {
        return $this->item['likeCounter'] ?? null;
    }

    public function getLastCommentTime(): ?DateTimeImmutable
    {
        $str = $this->item['lastCommentTime'] ?? null;
        return $str
            ? DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $str)
            : null;
    }

    public function getLastResBody(): ?string
    {
        return $this->item['lastResBody'] ?? null;
    }

    public function getTags(): array
    {
        return explode(' ', $this->item['tags'] ?? '');
    }

    public function getGenre(): ?string
    {
        return $this->item['genre'] ?? null;
    }

    public function getOwnerType(): ?string
    {
        return match (true) {
            $this->item['userId'] !== null => self::OWNER_TYPE_USER,
            $this->item['channelId'] !== null => self::OWNER_TYPE_CHANNEL,
            default => self::OWNER_TYPE_UNKNOWN,
        };
    }

    public function getOwnerId(): ?int
    {
        return match ($this->getOwnerType()) {
            self::OWNER_TYPE_USER => $this->item['userId'],
            self::OWNER_TYPE_CHANNEL => $this->item['channelId'],
            default => null,
        };
    }
}
