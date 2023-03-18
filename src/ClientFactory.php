<?php

declare(strict_types=1);

namespace NicoNicoRestClient;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientFactory
{
    public static function create(?HttpClientInterface $httpClient = null): Client
    {
        $httpClient = $httpClient ?? HttpClient::create();
        return new Client($httpClient);
    }
}
