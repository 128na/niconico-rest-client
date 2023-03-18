<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiSnapshot;

use Exception;
use NicoNicoRestClient\Base\Client as BaseClient;

class Client extends BaseClient
{
    protected string $endpoint = 'https://api.search.nicovideo.jp/api/v2/snapshot/video/contents/search';

    /**
     * @link https://site.nicovideo.jp/search-api-docs/snapshot.html
     */
    public function search(Query $query): Result
    {
        $url = sprintf(
            '%s?%s',
            $this->getEndpoint(),
            $query->toQueryString()
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new Result($response);
        $this->validateResult($result);

        return $result;
    }
}
