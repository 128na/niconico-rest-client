<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiExt;

use NicoNicoRestClient\Base\Client as BaseClient;
use NicoNicoRestClient\Exceptions\Exception;

class Client extends BaseClient
{
    protected string $endpoint = 'https://ext.nicovideo.jp/api/getthumbinfo';

    /**
     * @link https://dic.nicovideo.jp/a/%E3%83%8B%E3%82%B3%E3%83%8B%E3%82%B3%E5%8B%95%E7%94%BBapi
     */
    public function get(string $videoId): Result
    {
        $url = sprintf(
            '%s/%s',
            $this->getEndpoint(),
            $videoId
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new Result($response);
        $this->validateResult($result);

        return $result;
    }
}
