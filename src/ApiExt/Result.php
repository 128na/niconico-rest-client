<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiExt;

use NicoNicoRestClient\Base\XmlResult;
use NicoNicoRestClient\Contracts\Result as ContractsResult;
use NicoNicoRestClient\Contracts\SingleVideoResult;

class Result extends XmlResult implements SingleVideoResult, ContractsResult
{
    public function getVideo(): Video
    {
        return new Video($this->getBody());
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
