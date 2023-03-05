<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Contracts;

interface User
{
    /**
     * @return array<mixed>
     */
    public function getItem(): array;

    public function getId(): ?int;

    public function getNickname(): ?string;

    public function getThumbnailUrl(): ?string;
}
