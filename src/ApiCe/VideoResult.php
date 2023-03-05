<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiCe;

use NicoNicoRestClient\Base\JsonResult;
use NicoNicoRestClient\Contracts\Result;
use NicoNicoRestClient\Contracts\SingleVideoResult;

class VideoResult extends JsonResult implements SingleVideoResult, Result
{
    public function getVideo(): Video
    {
        return new Video($this->getBody()['niconico_response']);
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
