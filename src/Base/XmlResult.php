<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use NicoNicoRestClient\Helper\Functions;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class XmlResult extends Result
{
    public function __construct(protected ResponseInterface $response)
    {
        $this->body = Functions::xmlToJson($this->response->getContent());
    }
}
