<?php

declare(strict_types=1);

namespace NicoNicoApi\Rss;

use NicoNicoApi\Base\Client as BaseClient;
use NicoNicoApi\Exceptions\Exception;

class Client extends BaseClient
{
    protected string $endpoint = 'https://www.nicovideo.jp';

    public function user(int $userId, int $page = 1): Result
    {
        // https://www.nicovideo.jp/user/***/video?rss=atom
        $url = sprintf(
            '%s/user/%s/video?rss=atom&page=%s',
            $this->getEndpoint(),
            $userId,
            $page
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

    public function userMylist(int $userId, int $mylistId, int $page = 1): Result
    {
        // https://www.nicovideo.jp/user/***/mylist/***?rss=atom
        $url = sprintf(
            '%s/user/%s/mylist/%s?rss=atom&page=%s',
            $this->getEndpoint(),
            $userId,
            $mylistId,
            $page
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

    public function mylist(int $mylistId, int $page = 1): Result
    {
        // 301 redirect to https://www.nicovideo.jp/user/***/mylist/***?rss=atom
        $url = sprintf(
            '%s/mylist/%s?rss=atom&page=%s',
            $this->getEndpoint(),
            $mylistId,
            $page
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
