<?php

declare(strict_types=1);

namespace NicoNicoApi\Base;

use NicoNicoApi\Helper\Functions;
use SimpleXMLElement;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class XmlResult
{
    /**
     * @var array<mixed>
     */
    protected array $body;

    public function __construct(protected ResponseInterface $response)
    {
        $this->body = Functions::xmlToJson($this->response->getContent());
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
