<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class Result
{
    /**
     * @var array<mixed>
     */
    protected array $body = [];

    public function __construct(protected ResponseInterface $response)
    {
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return array<mixed>
     */
    public function getBody(): array
    {
        return $this->body ?? [];
    }
}
