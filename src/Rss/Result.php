<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Rss;

use NicoNicoRestClient\Base\XmlResult;
use NicoNicoRestClient\Contracts\MultipleVideosResult;
use NicoNicoRestClient\Contracts\Result as ContractsResult;

class Result extends XmlResult implements MultipleVideosResult, ContractsResult
{
    public function getVideos(): array
    {
        $items = is_array($this->getBody()['entry'])
            ? $this->getBody()['entry']
            : [$this->getBody()['entry']];
        return array_map(fn ($item) => new Video($item), $items);
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
