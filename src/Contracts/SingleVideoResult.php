<?php

declare(strict_types=1);

namespace NicoNicoApi\Contracts;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface SingleVideoResult
{
    public function getResponse(): ResponseInterface;

    /**
     * @return array<mixed>
     */
    public function getBody(): array;

    public function getVideo(): Video;

    public function statusOk(): bool;

    public function getErrorMessage(): string;
}
