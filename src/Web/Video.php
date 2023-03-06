<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Web;

use DateTimeImmutable;
use DateTimeInterface;
use DOMElement;
use DOMNode;
use DOMXPath;
use NicoNicoRestClient\Base\Video as BaseVideo;
use NicoNicoRestClient\Helper\Functions;

class Video extends BaseVideo
{
    protected DOMXPath $xpath;

    public function __construct(protected DOMNode $node)
    {
        $this->xpath = new DOMXPath($this->node);
        parent::__construct(Functions::elementToArray($this->node));
    }

    public function getContentId(): string
    {
        return $this->item['data-watch_id'];
    }

    public function getWatchUrl(): string
    {
        return $this->item['data-video_url'];
    }

    public function getTitle(): string
    {
        return $this->item['data-title'];
    }

    public function getUserId(): ?int
    {
        if ($this->item['data-owner_type'] === 'user') {
            return (int)$this->item['data-owner_id'];
        }
        return null;
    }

    public function getThumbnailUrl(): ?string
    {
        $node = $this->xpath->query('//*[@class="video-item-thumbnail"]')->item(0);

        return $node->textContent ?? null;
    }

    public function getStartTime(): ?DateTimeImmutable
    {
        $node = $this->xpath->query('//*[@class="video-item-date"]')->item(0);
        if ($node && $node->textContent) {
            return DateTimeImmutable::createFromFormat('Y-m-d', $node->textContent);
        }
        return null;
    }

    public function getLengthString(): string
    {
        return Functions::secondsToTimeString($this->getLengthSeconds());
    }

    public function getLengthSeconds(): int
    {
        return (int)$this->item['data-video_length'];
    }

    public function getViewCounter(): int
    {
        return (int)$this->item['data-view_counter'];
    }

    public function getCommentCounter(): int
    {
        return (int)$this->item['data-comment_counter'];
    }

    public function getMylistCounter(): int
    {
        return (int)$this->item['data-mylist_counter'];
    }

    public function getLikeCounter(): int
    {
        return (int)$this->item['data-like_counter'];
    }

    /**
     * チャンネル動画のみ、ユーザー投稿動画はnull
     */
    public function getChannelId(): ?int
    {
        if ($this->item['data-owner_type'] === 'channel') {
            return (int)str_replace('ch', '', $this->item['data-owner_id']);
        }
        return null;
    }

    // extra fields
    /**
     * ユーザー投稿動画のみ、チャンネル動画はnull
     */
    public function getUserNickname(): ?string
    {
        if ($this->item['data-owner_type'] === 'user') {
            return $this->item['data-owner_name'];
        }
        return null;
    }

    /**
     * ユーザー投稿動画のみ、チャンネル動画はnull
     */
    public function getUserIconUrl(): ?string
    {
        if ($this->item['data-owner_type'] === 'user') {
            return $this->item['data-owner_icon_url'];
        }
        return null;
    }
    /**
     * チャンネル動画のみ、ユーザー投稿動画はnull
     */
    public function getChannelName(): ?string
    {
        if ($this->item['data-owner_type'] === 'channel') {
            return $this->item['data-owner_name'];
        }
        return null;
    }

    /**
     * チャンネル動画のみ、ユーザー投稿動画はnull
     */
    public function getChannelIconUrl(): ?string
    {
        if ($this->item['data-owner_type'] === 'channel') {
            return $this->item['data-owner_icon_url'];
        }
        return null;
    }
}
