<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Rss;

use NicoNicoRestClient\Base\Client as BaseClient;

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
        $this->validateResponse($response);
        $result = new Result($response);
        $this->validateResult($result);

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
        $this->validateResponse($response);
        $result = new Result($response);
        $this->validateResult($result);

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
        $this->validateResponse($response);
        $result = new Result($response);
        $this->validateResult($result);

        return $result;
    }
}
