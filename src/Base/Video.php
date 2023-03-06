<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use DateTimeImmutable;
use NicoNicoRestClient\Contracts\Video as ContractsVideo;

abstract class Video implements ContractsVideo
{
    public const OWNER_TYPE_USER = 'user';
    public const OWNER_TYPE_CHANNEL = 'channel';
    public const OWNER_TYPE_UNKNOWN = null;

    /**
     * @param array<mixed> $item
     */
    public function __construct(protected array $item)
    {
    }

    public function getItem(): array
    {
        return $this->item;
    }

    public function getContentId(): ?string
    {
        return null;
    }

    public function getWatchUrl(): ?string
    {
        return null;
    }

    public function getTitle(): ?string
    {
        return null;
    }

    public function getDescription(): ?string
    {
        return null;
    }

    public function getThumbnailUrl(): ?string
    {
        return null;
    }

    public function getStartTime(): ?DateTimeImmutable
    {
        return null;
    }

    public function getLengthString(): ?string
    {
        return null;
    }

    public function getLengthSeconds(): ?int
    {
        return null;
    }

    public function getViewCounter(): ?int
    {
        return null;
    }

    public function getCommentCounter(): ?int
    {
        return null;
    }

    public function getMylistCounter(): ?int
    {
        return null;
    }

    public function getLikeCounter(): ?int
    {
        return null;
    }

    public function getLastCommentTime(): ?DateTimeImmutable
    {
        return null;
    }

    public function getLastResBody(): ?string
    {
        return null;
    }

    public function getTags(): array
    {
        return [];
    }

    public function getGenre(): ?string
    {
        return null;
    }

    public function getOwnerType(): ?string
    {
        return null;
    }

    public function getOwnerId(): ?int
    {
        return null;
    }

    public function getOwnerName(): ?string
    {
        return null;
    }

    public function getOwnerIconUrl(): ?string
    {
        return null;
    }
}
