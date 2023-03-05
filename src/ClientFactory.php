<?php

declare(strict_types=1);

namespace NicoNicoApi;

use NicoNicoApi\Base\Client;
use NicoNicoApi\ExtApi\Client as ExtApiClient;
use NicoNicoApi\FlApi\Client as FlApiClient;
use NicoNicoApi\Rss\Client as RssClient;
use NicoNicoApi\SnapshotApi\Client as SnapshotApiClient;
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
        return match ($clientName) {
            self::SNAPSHOT_API => new SnapshotApiClient($httpClient ?? HttpClient::create()),
            self::EXT_API => new ExtApiClient($httpClient ?? HttpClient::create()),
            self::FL_API => new FlApiClient($httpClient ?? HttpClient::create()),
            self::RSS => new RssClient($httpClient ?? HttpClient::create()),
        };
    }
}
