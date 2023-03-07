<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Base;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

abstract class HtmlResult extends Result
{
    protected Crawler $crawler;

    public function __construct(protected ResponseInterface $response)
    {
        $this->crawler = new Crawler($this->response->getContent());
    }

    public function getCrawler(): Crawler
    {
        return $this->crawler;
    }
}
