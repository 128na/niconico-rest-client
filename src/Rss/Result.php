<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Rss;

use NicoNicoRestClient\Base\XmlResult;
use NicoNicoRestClient\Contracts\MultipleVideosResult;

class Result extends XmlResult implements MultipleVideosResult
{
    public function getVideos(): array
    {
        return array_map(fn ($item) => new Video($item), $this->getBody()['entry'] ?? []);
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
