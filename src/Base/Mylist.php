<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use NicoNicoRestClient\Contracts\Mylist as ContractsMylist;

abstract class Mylist implements ContractsMylist
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

    public function getUserId(): ?int
    {
        return null;
    }

    public function getName(): ?string
    {
        return null;
    }

    public function getDescription(): ?string
    {
        return null;
    }

    public function getPublic(): ?bool
    {
        return null;
    }

    public function getDefaultSort(): ?bool
    {
        return null;
    }

    public function getDefaultSortMethod(): ?string
    {
        return null;
    }

    public function getDefaultSortOrder(): ?string
    {
        return null;
    }

    public function getCount(): ?int
    {
        return null;
    }
}
