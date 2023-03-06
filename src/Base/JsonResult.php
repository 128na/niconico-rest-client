<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class JsonResult extends Result
{
    public function __construct(protected ResponseInterface $response)
    {
        $this->body = $this->response->toArray();
    }
}
