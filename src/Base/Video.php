<?php

declare(strict_types=1);

namespace NicoNicoApi\Base;

use DateTimeImmutable;
use NicoNicoApi\Contracts\Video as ContractsVideo;

abstract class Video implements ContractsVideo
{
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

    public function getUserId(): ?int
    {
        return null;
    }

    public function getUserNickname(): ?string
    {
        return null;
    }

    public function getUserIconUrl(): ?string
    {
        return null;
    }

    public function getThumbnailUrl(): ?string
    {
        return null;
    }

    public function getThumbType(): ?string
    {
        return null;
    }

    public function getEmbeddable(): ?bool
    {
        return null;
    }

    public function getNoLivePlay(): ?bool
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

    public function getMovieType(): ?string
    {
        return null;
    }

    public function getSizeHigh(): ?int
    {
        return null;
    }

    public function getSizeLow(): ?int
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

    public function getTagsString(): ?string
    {
        return null;
    }

    public function getTagsArray(): array
    {
        return [];
    }

    public function getCategoryTagsString(): ?string
    {
        return null;
    }

    public function getCategoryTagsArray(): array
    {
        return [];
    }

    public function getGenre(): ?string
    {
        return null;
    }

    public function getChannelId(): ?string
    {
        return null;
    }
}
