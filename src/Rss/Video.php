<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Rss;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\Base\Video as BaseVideo;
use NicoNicoRestClient\Helper\Functions;

class Video extends BaseVideo
{
    public function getContentId(): ?string
    {
        return Functions::getContentIdFromUrl($this->getWatchUrl());
    }

    public function getWatchUrl(): ?string
    {
        return $this->item['link']['@attributes']['href'];
    }

    public function getTitle(): ?string
    {
        return $this->item['title'];
    }

    public function getDescription(): ?string
    {
        return strip_tags($this->getDescriptionHtml());
    }

    public function getDescriptionHtml(): ?string
    {
        return trim($this->item['content']);
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->item['media_thumbnail']['@attributes']['url'];
    }

    public function getStartTime(): ?DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $this->item['published']);
    }
}
