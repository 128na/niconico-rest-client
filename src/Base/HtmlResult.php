<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use DOMDocument;
use DOMXPath;
use NicoNicoRestClient\Helper\Functions;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class HtmlResult extends Result
{
    protected DOMDocument $dom;
    protected DOMXPath $xpath;

    public function __construct(protected ResponseInterface $response)
    {
        $this->dom = new DOMDocument();
        $this->dom->loadHTML($this->response->getContent());
        $this->xpath = new DOMXPath($this->dom);
        $this->body = Functions::elementToArray($this->dom->documentElement);
    }

    public function getDom(): DOMDocument
    {
        return $this->dom;
    }

    public function getXpath(): DOMXPath
    {
        return $this->xpath;
    }
}
