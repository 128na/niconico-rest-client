<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Web;

use NicoNicoRestClient\Base\HtmlResult;
use NicoNicoRestClient\Contracts\MultipleVideosResult;
use NicoNicoRestClient\Contracts\Result as ContractsResult;
use Symfony\Component\DomCrawler\Crawler;

class Result extends HtmlResult implements MultipleVideosResult, ContractsResult
{
    public function getVideos(): array
    {
        return $this->getCrawler()
            ->filterXPath('//*[@id="jsVideoList"]/ul/li')
            ->each(fn (Crawler $node) => new Video($node));
    }

    public function statusOk(): bool
    {
        return true;
    }

    public function getErrorMessage(): ?string
    {
        return null;
    }
}
