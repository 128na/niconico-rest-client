<?php

declare(strict_types=1);

namespace NicoNicoApi\SnapshotApi;

use NicoNicoApi\Base\JsonResult;
use NicoNicoApi\Contracts\MultipleVideosResult;

class Result extends JsonResult implements MultipleVideosResult
{
    /**
     * @return array<Video>
     */
    public function getVideos(): array
    {
        return array_map(fn ($item) => new Video($item), $this->getBody()['data'] ?? []);
    }

    /**
     * 失敗時はfailになる
     */
    public function statusOk(): bool
    {
        return $this->body['meta']['status'] === 200;
    }

    public function getErrorMessage(): string
    {
        return sprintf(
            '%s : %s',
            isset($this->body['meta']['errorCode']) ? $this->body['meta']['errorCode'] : '',
            isset($this->body['meta']['errorMessage']) ? $this->body['meta']['errorMessage'] : ''
        );
    }
}
