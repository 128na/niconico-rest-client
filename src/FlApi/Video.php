<?php

declare(strict_types=1);

namespace NicoNicoApi\FlApi;

use DateTimeImmutable;
use NicoNicoApi\Base\Video as BaseVideo;
use NicoNicoApi\Helper\Functions;

class Video extends BaseVideo
{
    public function getContentId(): ?string
    {
        return Functions::getContentIdFromUrl($this->getWatchUrl());
    }

    public function getWatchUrl(): ?string
    {
        return $this->item['url'];
    }

    public function getTitle(): ?string
    {
        return $this->item['title'];
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->item['thumbnail'];
    }

    public function getStartTime(): ?DateTimeImmutable
    {
        return (new  DateTimeImmutable())->setTimestamp($this->item['startTime']);
    }

    public function getLengthString(): ?string
    {
        return Functions::secondsToTimeString($this->getLengthSeconds());
    }

    public function getLengthSeconds(): ?int
    {
        return (int)$this->item['length'];
    }

    public function getViewCounter(): ?int
    {
        return (int)$this->item['view'];
    }

    public function getCommentCounter(): ?int
    {
        return (int)$this->item['comment'];
    }

    public function getMylistCounter(): ?int
    {
        return (int)$this->item['mylist'];
    }
}
