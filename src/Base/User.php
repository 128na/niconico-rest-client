<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use NicoNicoRestClient\Contracts\User as ContractsUser;

abstract class User implements ContractsUser
{
    /**
     * @param array<mixed> $item
     */
    public function __construct(protected array $item)
    {
    }

    /**
     * @return array<mixed>
     */
    public function getItem(): array
    {
        return $this->item;
    }

    public function getId(): ?int
    {
        return null;
    }
    public function getNickname(): ?string
    {
        return null;
    }
    public function getThumbnailUrl(): ?string
    {
        return null;
    }
}
