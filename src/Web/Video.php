<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Web;

use DateTimeImmutable;
use DateTimeInterface;
use NicoNicoRestClient\Base\Video as BaseVideo;
use NicoNicoRestClient\Helper\Functions;
use Symfony\Component\DomCrawler\Crawler;

class Video extends BaseVideo
{
    public function __construct(protected Crawler $node)
    {
        parent::__construct([]);
    }

    public function getContentId(): ?string
    {
        return $this->node->attr('data-watch_id');
    }

    public function getWatchUrl(): ?string
    {
        return $this->node->attr('data-video_url');
    }

    public function getTitle(): ?string
    {
        return $this->node->attr('data-title');
    }

    public function getThumbnailUrl(): ?string
    {
        $node = $this->node->filterXPath('//img');
        return $node->count() ? $node->attr('data-original') : null;
    }

    public function getStartTime(): ?DateTimeImmutable
    {
        $node = $this->node->filterXPath('//*[@class="video-item-date"]')->first();

        if ($node->count() && $node->text()) {
            $date = str_replace('/', '-', $node->text());
            return DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, sprintf('%sT00:00:00+09:00', $date));
        }
        return null;
    }

    public function getLengthString(): string
    {
        return Functions::secondsToTimeString($this->getLengthSeconds());
    }

    public function getLengthSeconds(): int
    {
        return (int)$this->node->attr('data-video_length');
    }

    public function getViewCounter(): int
    {
        return (int)$this->node->attr('data-view_counter');
    }

    public function getCommentCounter(): int
    {
        return (int)$this->node->attr('data-comment_counter');
    }

    public function getMylistCounter(): int
    {
        return (int)$this->node->attr('data-mylist_counter');
    }

    public function getLikeCounter(): int
    {
        return (int)$this->node->attr('data-like_counter');
    }

    public function getOwnerType(): ?string
    {
        return match ($this->node->attr('data-owner_type')) {
            'user' => self::OWNER_TYPE_USER,
            'channel' => self::OWNER_TYPE_CHANNEL,
            default => self::OWNER_TYPE_UNKNOWN,
        };
    }

    public function getOwnerId(): ?int
    {
        return match ($this->getOwnerType()) {
            self::OWNER_TYPE_USER => (int)$this->node->attr('data-owner_id'),
            self::OWNER_TYPE_CHANNEL => Functions::getChannelId($this->node->attr('data-owner_id')),
            default => null,
        };
    }

    public function getOwnerName(): ?string
    {
        return $this->node->attr('data-owner_name');
    }

    public function getOwnerIconUrl(): ?string
    {
        return $this->node->attr('data-owner_icon_url');
    }

    // extra fields
    public function getOwnerUrl(): ?string
    {
        return $this->node->attr('data-owner_url');
    }
}
