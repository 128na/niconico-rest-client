<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiFl;

use NicoNicoRestClient\Base\Client as BaseClient;
use NicoNicoRestClient\Exceptions\Exception;

class Client extends BaseClient
{
    protected string $endpoint = 'https://ApiFl.nicovideo.jp/api/getrelation';

    /**
     * @link https://dic.nicovideo.jp/a/%E3%83%8B%E3%82%B3%E3%83%8B%E3%82%B3%E5%8B%95%E7%94%BBapi
     */
    public function list(string $videoId): Result
    {
        $url = sprintf(
            '%s?video=%s',
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
