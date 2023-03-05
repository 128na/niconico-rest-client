<?php

declare(strict_types=1);

namespace NicoNicoApi\Contracts;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface MultipleVideosResult
{
    public function getResponse(): ResponseInterface;

    /**
     * @return array<mixed>
     */
    public function getBody(): array;

    /**
     * @return array<Video>
     */
    public function getVideos(): array;

    public function statusOk(): bool;

    public function getErrorMessage(): ?string;
}
