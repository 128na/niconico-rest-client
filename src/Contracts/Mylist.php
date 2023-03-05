<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Contracts;

interface Mylist
{
    /**
     * @return array<mixed>
     */
    public function getItem(): array;

    public function getId(): ?int;

    public function getUserId(): ?int;

    public function getName(): ?string;

    public function getDescription(): ?string;

    public function getPublic(): ?bool;

    public function getDefaultSort(): ?bool;

    public function getDefaultSortMethod(): ?string;

    public function getDefaultSortOrder(): ?string;

    public function getCount(): ?int;
}
