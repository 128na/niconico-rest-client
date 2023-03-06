<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Contracts;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface Result
{
    public function getResponse(): ResponseInterface;

    public function statusOk(): bool;

    public function getErrorMessage(): ?string;
}
