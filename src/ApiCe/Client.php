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
            '%s/api/v1/user.info?__format=json&user_id=%s',
            $this->getEndpoint(),
            $userId
        );
        $response = $this->httpClient->request('GET', $url);
        $this->validateResponse($response);
        $result = new UserResult($response);
        $this->validateResult($result);

        return $result;
    }

    // public function videoInfo(string $videoId): VideoResult

    /**
     * @param array<string> $videoIds
     */
    // public function videoArray(array $videoIds): VideoListResult
    // public function mylistGroup(int $groupId): VideoListResult
    // public function mylistList(int $groupId): VideoListResult
    // public function userMyVideo(int $userId): VideoListResult
}
