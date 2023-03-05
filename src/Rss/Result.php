<?php

declare(strict_types=1);

namespace NicoNicoApi\Rss;

use NicoNicoApi\Base\XmlResult;
use NicoNicoApi\Contracts\MultipleVideosResult;

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
