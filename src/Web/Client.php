<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Web;

use NicoNicoRestClient\Base\Client as BaseClient;

class Client extends BaseClient
{
    protected string $endpoint = 'https://sp.nicovideo.jp';

    public function series(int $seriesId): Result
    {
        $url = sprintf(
            '%s/series/%d',
            $this->getEndpoint(),
            $seriesId,
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new Result($response);
        $this->validateResult($result);

        return $result;
    }
}
