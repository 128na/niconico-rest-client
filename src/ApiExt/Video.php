<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiExt;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\Base\Video as BaseVideo;
use NicoNicoRestClient\Helper\Functions;

class Video extends BaseVideo
{
    public function getContentId(): string
    {
        return $this->item['thumb']['video_id'];
    }

    public function getWatchUrl(): string
    {
        return $this->item['thumb']['watch_url'];
    }

    public function getTitle(): string
    {
        return $this->item['thumb']['title'];
    }

    public function getDescription(): string
    {
        return $this->item['thumb']['description'];
    }

    public function getThumbnailUrl(): string
    {
        return $this->item['thumb']['thumbnail_url'];
    }

    public function getStartTime(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $this->item['thumb']['first_retrieve']);
    }

    public function getLengthString(): string
    {
        return $this->item['thumb']['length'];
    }

    public function getLengthSeconds(): int
    {
        return Functions::timeStringToSeconds($this->getLengthString());
    }

    public function getViewCounter(): int
    {
        return (int)$this->item['thumb']['view_counter'];
    }

    public function getCommentCounter(): int
    {
        return (int)$this->item['thumb']['comment_num'];
    }

    public function getMylistCounter(): int
    {
        return (int)$this->item['thumb']['mylist_counter'];
    }

    public function getLastResBody(): string
    {
        return $this->item['thumb']['last_res_body'];
    }

    public function getTags(): array
    {
        return $this->item['thumb']['tags']['tag'];
    }

    public function getGenre(): string
    {
        return $this->item['thumb']['genre'];
    }

    // extra fields


    public function getThumbType(): string
    {
        return $this->item['thumb']['thumb_type'];
    }

    public function getEmbeddable(): bool
    {
        return (bool)$this->item['thumb']['embeddable'];
    }

    public function getNoLivePlay(): bool
    {
        return (bool)$this->item['thumb']['no_live_play'];
    }

    public function getMovieType(): string
    {
        return $this->item['thumb']['movie_type'];
    }

    public function getSizeHigh(): int
    {
        return (int)$this->item['thumb']['size_high'];
    }

    public function getSizeLow(): int
    {
        return (int)$this->item['thumb']['size_low'];
    }

    public function getOwnerType(): ?string
    {
        return match (true) {
            isset($this->item['thumb']['user_id']) => self::OWNER_TYPE_USER,
            isset($this->item['thumb']['ch_id']) => self::OWNER_TYPE_CHANNEL,
            default => self::OWNER_TYPE_UNKNOWN
        };
    }

    public function getOwnerId(): ?int
    {
        return match ($this->getOwnerType()) {
            self::OWNER_TYPE_USER => (int)$this->item['thumb']['user_id'],
            self::OWNER_TYPE_CHANNEL => (int)$this->item['thumb']['ch_id'],
            default => null,
        };
    }

    public function getOwnerName(): ?string
    {
        return match ($this->getOwnerType()) {
            self::OWNER_TYPE_USER => $this->item['thumb']['user_nickname'],
            self::OWNER_TYPE_CHANNEL => $this->item['thumb']['ch_name'],
            default => null,
        };
    }

    public function getOwnerIconUrl(): ?string
    {
        return match ($this->getOwnerType()) {
            self::OWNER_TYPE_USER => $this->item['thumb']['user_icon_url'],
            self::OWNER_TYPE_CHANNEL => $this->item['thumb']['ch_icon_url'],
            default => null,
        };
    }
}
