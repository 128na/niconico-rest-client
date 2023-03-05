<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiCe;

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

    public function getUserId(): ?int
    {
        return $this->item['userId'] ?? null;
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

    public function getTagsArray(): array
    {
        return explode(' ', $this->item['tags'] ?? '');
    }

    public function getTagsString(): ?string
    {
        return $this->item['tags'] ?? null;
    }

    public function getCategoryTagsArray(): array
    {
        return explode(' ', $this->item['categoryTags'] ?? '');
    }

    public function getCategoryTagsString(): ?string
    {
        return $this->item['categoryTags'] ?? null;
    }

    public function getGenre(): ?string
    {
        return $this->item['genre'] ?? null;
    }

    public function getChannelId(): ?int
    {
        return isset($this->item['channelId'])
            ? (int)$this->item['channelId']
            : null;
    }
}
