<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiCe;

use NicoNicoRestClient\Base\User as BaseUser;

class User extends BaseUser
{
    public function getId(): int
    {
        return (int)$this->item['user']['id'];
    }

    public function getNickname(): string
    {
        return $this->item['user']['nickname'];
    }

    public function getThumbnailUrl(): string
    {
        return $this->item['user']['thumbnail_url'];
    }
}
