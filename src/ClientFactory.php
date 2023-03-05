<?php

declare(strict_types=1);

namespace NicoNicoRestClient;

use NicoNicoRestClient\Base\Client;
use NicoNicoRestClient\Exceptions\ClientFactoryException;
use NicoNicoRestClient\ExtApi\Client as ExtApiClient;
use NicoNicoRestClient\FlApi\Client as FlApiClient;
use NicoNicoRestClient\Rss\Client as RssClient;
use NicoNicoRestClient\SnapshotApi\Client as SnapshotApiClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientFactory
{
    public const SNAPSHOT_API = SnapshotApiClient::class;
    public const EXT_API = ExtApiClient::class;
    public const FL_API = FlApiClient::class;
    public const RSS = RssClient::class;

    public static function create(string $clientName, ?HttpClientInterface $httpClient = null): Client
    {
        $httpClient = $httpClient ?? HttpClient::create();
        return match ($clientName) {
            self::SNAPSHOT_API => new SnapshotApiClient($httpClient),
            self::EXT_API => new ExtApiClient($httpClient),
            self::FL_API => new FlApiClient($httpClient),
            self::RSS => new RssClient($httpClient),

            default => throw new ClientFactoryException("$clientName is not defined in ClientFactory const values."),
        };
    }
}
