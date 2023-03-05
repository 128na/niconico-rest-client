<?php

declare(strict_types=1);

namespace NicoNicoApi\ExtApi;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoApi\Base\Video as BaseVideo;
use NicoNicoApi\Helper\Functions;

class Video extends BaseVideo
{
    public function getContentId(): ?string
    {
        return $this->item['video_id'];
    }

    public function getWatchUrl(): ?string
    {
        return $this->item['watch_url'];
    }

    public function getTitle(): ?string
    {
        return $this->item['title'];
    }

    public function getDescription(): ?string
    {
        return $this->item['description'];
    }

    public function getUserId(): ?int
    {
        return $this->item['user_id'];
    }

    public function getUserNickname(): ?string
    {
        return $this->item['user_nickname'];
    }

    public function getUserIconUrl(): ?string
    {
        return $this->item['user_icon_url'];
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->item['thumbnail_url'];
    }

    public function getThumbType(): ?string
    {
        return $this->item['thumb_type'];
    }

    public function getEmbeddable(): ?bool
    {
        return (bool)$this->item['embeddable'];
    }

    public function getNoLivePlay(): ?bool
    {
        return (bool)$this->item['no_live_play'];
    }

    public function getStartTime(): ?DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $this->item['first_retrieve']);
    }

    public function getLengthString(): ?string
    {
        return $this->item['length'];
    }

    public function getLengthSeconds(): ?int
    {
        return Functions::timeStringToSeconds($this->getLengthString());
    }

    public function getMovieType(): ?string
    {
        return $this->item['movie_type'];
    }

    public function getSizeHigh(): ?int
    {
        return (int)$this->item['size_high'];
    }

    public function getSizeLow(): ?int
    {
        return (int)$this->item['size_low'];
    }

    public function getViewCounter(): ?int
    {
        return (int)$this->item['view_counter'];
    }

    public function getCommentCounter(): ?int
    {
        return (int)$this->item['comment_num'];
    }

    public function getMylistCounter(): ?int
    {
        return (int)$this->item['mylist_counter'];
    }

    public function getLastResBody(): ?string
    {
        return $this->item['last_res_body'];
    }

    public function getTagsString(): ?string
    {
        return implode(' ', $this->getTagsArray());
    }

    public function getTagsArray(): array
    {
        return $this->item['tags']['tag'];
    }

    public function getGenre(): ?string
    {
        return $this->item['genre'];
    }
}
