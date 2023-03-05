<?php

declare(strict_types=1);

namespace NicoNicoApi\FlApi;

use NicoNicoApi\Base\XmlResult;
use NicoNicoApi\Contracts\MultipleVideosResult;

class Result extends XmlResult implements MultipleVideosResult
{
    public function getVideos(): array
    {
        return array_map(fn ($item) => new Video($item), $this->getBody()['video'] ?? []);
    }

    /**
     * 失敗時はfailになる
     */
    public function statusOk(): bool
    {
        return $this->body['@attributes']['status'] === 'ok';
    }

    public function getErrorMessage(): string
    {
        return sprintf(
            '%s : %s',
            isset($this->body['error']['code']) ? $this->body['error']['code'] : '',
            isset($this->body['error']['description']) ? $this->body['error']['description'] : ''
        );
    }
}
