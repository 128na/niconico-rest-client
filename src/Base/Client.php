<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use NicoNicoRestClient\Contracts\Result;
use NicoNicoRestClient\Exceptions\Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

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

    protected function validateResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() !== 200) {
            throw new Exception(sprintf('"%s" returns status code %d.', $this->getEndpoint(), $response->getStatusCode()));
        }
    }

    protected function validateResult(Result $result): void
    {
        if (!$result->statusOk()) {
            throw new Exception($result->getErrorMessage());
        }
    }
}
