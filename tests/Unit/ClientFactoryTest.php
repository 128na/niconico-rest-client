<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use NicoNicoRestClient\ApiCe\Client as ApiCeClient;
use NicoNicoRestClient\ApiExt\Client as ApiExtClient;
use NicoNicoRestClient\ApiSnapshot\Client as ApiSnapshotClient;
use NicoNicoRestClient\Client;
use NicoNicoRestClient\ClientFactory;
use NicoNicoRestClient\Rss\Client as RssClient;
use NicoNicoRestClient\Web\Client as WebClient;

class ClientFactoryTest extends TestCase
{
    public function test()
    {
        $actual = ClientFactory::create();
        $this->assertInstanceOf(Client::class, $actual);

        $this->assertInstanceOf(ApiCeClient::class, $actual->getApiCeClient());
        $this->assertInstanceOf(ApiExtClient::class, $actual->getApiExtClient());
        $this->assertInstanceOf(ApiSnapshotClient::class, $actual->getApiSnapshotClient());
        $this->assertInstanceOf(RssClient::class, $actual->getRssClient());
        $this->assertInstanceOf(WebClient::class, $actual->getWebClient());
    }
}
