<?php

declare(strict_types=1);

namespace NicoNicoRestClient\ApiCe;

use NicoNicoRestClient\Base\Client as BaseClient;

class Client extends BaseClient
{
    protected string $endpoint = 'https://api.ce.nicovideo.jp';

    public function userInfo(int $userId): UserResult
    {
        $url = sprintf(
            '%s/api/v1/user.info?__format=json&user_id=%d',
            $this->getEndpoint(),
            $userId
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new UserResult($response);
        $this->validateResult($result);

        return $result;
    }

    public function videoInfo(string $videoId): VideoResult
    {
        $url = sprintf(
            '%s/nicoapi/v1/video.info?__format=json&v=%s',
            $this->getEndpoint(),
            $videoId
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new VideoResult($response);
        $this->validateResult($result);

        return $result;
    }

    /**
     * @param array<string> $videoIds
     */
    public function videoArray(array $videoIds): VideoListResult
    {
        $url = sprintf(
            '%s/nicoapi/v1/video.info?__format=json&v=%s',
            $this->getEndpoint(),
            implode(',', $videoIds)
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new VideoListResult($response);
        $this->validateResult($result);

        return $result;
    }

    public function mylistGroup(int $groupId): MylistResult
    {
        $url = sprintf(
            '%s/nicoapi/v1/mylistgroup.get?__format=json&group_id=%d&detail=1',
            $this->getEndpoint(),
            $groupId
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new MylistResult($response);
        $this->validateResult($result);

        return $result;
    }

    public function mylistList(int $groupId, int $page = 1): VideoListResult
    {
        $url = sprintf(
            '%s/nicoapi/v1/mylist.list?__format=json&group_id=%d&limit=50&from=%d',
            $this->getEndpoint(),
            $groupId,
            ($page - 1) * 50
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new VideoListResult($response);
        $this->validateResult($result);

        return $result;
    }

    public function userMyVideo(int $userId, int $page = 1): VideoListResult
    {
        $url = sprintf(
            '%s/nicoapi/v1/user.myvideo?__format=json&user_id=%d&from=%d',
            $this->getEndpoint(),
            $userId,
            ($page - 1) * 100
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new VideoListResult($response);
        $this->validateResult($result);

        return $result;
    }
}
