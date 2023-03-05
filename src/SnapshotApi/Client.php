<?php

declare(strict_types=1);

namespace NicoNicoApi\SnapshotApi;

use Exception;
use NicoNicoApi\Base\Client as BaseClient;

class Client extends BaseClient
{
    protected string $endpoint = 'https://api.search.nicovideo.jp/api/v2/snapshot/video/contents/search';

    /**
     * @link https://site.nicovideo.jp/search-api-docs/snapshot.html
     */
    public function list(Query $query): Result
    {
        $url = sprintf(
            '%s?%s',
            $this->getEndpoint(),
            $query->toQueryString()
        );
        $response = $this->httpClient->request('GET', $url);
        if ($response->getStatusCode() !== 200) {
            throw new Exception(sprintf('"%s" returns status code %d.', $url, $response->getStatusCode()));
        }

        $result = new Result($response);
        if (!$result->statusOk()) {
            throw new Exception($result->getErrorMessage());
        }
        return $result;
    }
}
