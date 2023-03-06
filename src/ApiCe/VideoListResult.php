<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiCe;

use NicoNicoRestClient\Base\JsonResult;
use NicoNicoRestClient\Contracts\MultipleVideosResult;
use NicoNicoRestClient\Contracts\Result;

class VideoListResult extends JsonResult implements MultipleVideosResult, Result
{
    public function getVideos(): array
    {
        return array_map(fn ($item) => new Video($item), $this->getBody()['niconico_response']['video_info']);
    }

    public function getTotalCount(): ?int
    {
        return $this->getTotalCountMylist() ?? $this->getTotalCountUser() ?? null;
    }

    public function getTotalCountMylist(): ?int
    {
        return isset($this->body['niconico_response']['total_count'])
            ? (int)$this->body['niconico_response']['total_count']
            : null;
    }

    public function getTotalCountUser(): ?int
    {
        return isset($this->body['niconico_response']['full_count'])
            ? (int)$this->body['niconico_response']['full_count']
            : null;
    }

    public function statusOk(): bool
    {
        return $this->body['niconico_response']['@status'] === 'ok';
    }

    public function getErrorMessage(): string
    {
        return sprintf(
            '%s : %s',
            isset($this->body['niconico_response']['error']['code']) ? $this->body['niconico_response']['error']['code'] : '',
            isset($this->body['niconico_response']['error']['description']) ? $this->body['niconico_response']['error']['description'] : ''
        );
    }
}
