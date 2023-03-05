<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiFl;

use NicoNicoRestClient\Base\XmlResult;
use NicoNicoRestClient\Contracts\MultipleVideosResult;

class Result extends XmlResult implements MultipleVideosResult
{
    public function getVideos(): array
    {
        $items = is_array($this->getBody()['video'])
            ? $this->getBody()['video']
            : [$this->getBody()['video']];

        return array_map(fn ($item) => new Video($item), $items);
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
