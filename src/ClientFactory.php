<?php

declare(strict_types=1);

namespace NicoNicoRestClient;

use NicoNicoRestClient\Base\Client;
use NicoNicoRestClient\Exceptions\ClientFactoryException;
use NicoNicoRestClient\ApiExt\Client as ApiExtClient;
use NicoNicoRestClient\ApiFl\Client as ApiFlClient;
use NicoNicoRestClient\ApiCe\Client as ApiCeClient;
use NicoNicoRestClient\Rss\Client as RssClient;
use NicoNicoRestClient\ApiSnapshot\Client as ApiSnapshotClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientFactory
{
    public const API_SNAPSHOT = ApiSnapshotClient::class;
    public const API_EXT = ApiExtClient::class;
    public const API_FL = ApiFlClient::class;
    public const API_CE = ApiCeClient::class;
    public const RSS = RssClient::class;

    public static function create(string $clientName, ?HttpClientInterface $httpClient = null): Client
    {
        $httpClient = $httpClient ?? HttpClient::create();
        return match ($clientName) {
            self::API_SNAPSHOT => new ApiSnapshotClient($httpClient),
            self::API_EXT => new ApiExtClient($httpClient),
            self::API_FL => new ApiFlClient($httpClient),
            self::API_CE => new ApiCeClient($httpClient),
            self::RSS => new RssClient($httpClient),

            default => throw new ClientFactoryException("$clientName is not defined in ClientFactory const values."),
        };
    }
}
