<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiCe;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\Base\Video as BaseVideo;
use NicoNicoRestClient\Helper\Functions;

class Video extends BaseVideo
{
    public function getContentId(): string
    {
        return $this->item['video']['id'];
    }

    public function getWatchUrl(): string
    {
        return Functions::getWatchUrlFromContentId($this->getContentId());
    }

    public function getTitle(): string
    {
        return $this->item['video']['title'];
    }

    public function getDescription(): string
    {
        return $this->item['video']['description'];
    }

    public function getThumbnailUrl(): string
    {
        return $this->item['video']['thumbnail_url'];
    }

    public function getStartTime(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $this->item['video']['first_retrieve']);
    }

    public function getLengthString(): string
    {
        return Functions::secondsToTimeString($this->getLengthSeconds());
    }

    public function getLengthSeconds(): int
    {
        return (int)$this->item['video']['length_in_seconds'];
    }

    public function getViewCounter(): int
    {
        return (int)$this->item['video']['view_counter'];
    }

    public function getCommentCounter(): int
    {
        return (int)$this->item['thread']['num_res'];
    }

    public function getMylistCounter(): int
    {
        return (int)$this->item['video']['mylist_counter'];
    }

    public function getTags(): array
    {
        return isset($this->item['tags']['tag_info'])
            ? array_map(fn ($t): string => $t['tag'], $this->item['tags']['tag_info'])
            : [];
    }

    public function getGenre(): ?string
    {
        return isset($this->item['video']['genre']['label'])
            ? $this->item['video']['genre']['label']
            : null;
    }

    public function getOwnerType(): ?string
    {
        return match ($this->item['video']['option_flag_community']) {
            '0' => self::OWNER_TYPE_USER,
            '1' => self::OWNER_TYPE_CHANNEL,
            default => self::OWNER_TYPE_UNKNOWN
        };
    }

    public function getOwnerId(): ?int
    {
        return match ($this->getOwnerType()) {
            self::OWNER_TYPE_USER => (int)$this->item['video']['user_id'],
            self::OWNER_TYPE_CHANNEL => Functions::getChannelId($this->item['video']['community_id']),
            default => null,
        };
    }

    // extra fields

    public function getDeleted(): bool
    {
        return (bool)$this->item['video']['deleted'];
    }

    public function getMylistItemId(): ?int
    {
        return isset($this->item['mylist']['item_id'])
            ? (int)$this->item['mylist']['item_id']
            : null;
    }

    public function getMylistDescription(): ?string
    {
        return isset($this->item['mylist']['description'])
            ? $this->item['mylist']['description']
            : null;
    }

    public function getMylistCreateTime(): ?DateTimeImmutable
    {
        return isset($this->item['mylist']['create_time'])
            ? DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $this->item['mylist']['create_time'])
            : null;
    }
}
