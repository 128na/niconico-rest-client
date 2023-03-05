<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class Client
{
    protected string $endpoint;

    public function __construct(protected HttpClientInterface $httpClient)
    {
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }
}
