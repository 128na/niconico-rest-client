<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Web;

use NicoNicoRestClient\Base\HtmlResult;
use NicoNicoRestClient\Contracts\MultipleVideosResult;
use NicoNicoRestClient\Contracts\Result as ContractsResult;
use DOMNodeList;
use DOMNode;
use NicoNicoRestClient\Helper\Functions;

class Result extends HtmlResult implements MultipleVideosResult, ContractsResult
{
    public function getVideos(): array
    {
        /** @var DOMNodeList  */
        $items = $this->getXpath()->query('//*[@id="jsVideoList"]/ul/li');
        $videos = [];
        /** @var DOMNode $item */
        foreach ($items as $item) {
            $videos[] = new Video($item);
        }
        return $videos;
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
