<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use NicoNicoRestClient\ApiCe\Client as ApiCeClient;
use NicoNicoRestClient\ApiExt\Client as ApiExtClient;
use NicoNicoRestClient\ApiFl\Client as ApiFlClient;
use NicoNicoRestClient\ApiSnapshot\Client as ApiSnapshotClient;
use NicoNicoRestClient\ClientFactory;
use NicoNicoRestClient\Rss\Client as RssClient;

class ClientFactoryTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test(string $clientName, string $expectClass)
    {
        $actual = ClientFactory::create($clientName);
        $this->assertInstanceOf($expectClass, $actual);
    }

    public static function dataProvider()
    {
        return [
            [ClientFactory::API_CE, ApiCeClient::class],
            [ClientFactory::API_EXT, ApiExtClient::class],
            [ClientFactory::API_FL, ApiFlClient::class],
            [ClientFactory::API_SNAPSHOT, ApiSnapshotClient::class],
            [ClientFactory::RSS, RssClient::class],
        ];
    }
}
