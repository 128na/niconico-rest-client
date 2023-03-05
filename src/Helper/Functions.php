<?php

declare(strict_types=1);

namespace NicoNicoRestClient\Helper;

class Functions
{
    public static function timeStringToSeconds(string $timeStr): int
    {
        $chunk = array_reverse(explode(':', $timeStr));
        $sec = 0;
        for ($i = 0; $i < count($chunk); $i++) {
            $sec += intval($chunk[$i]) * (60 ** $i);
        }
        return $sec;
    }

    public static function secondsToTimeString(int $seconds): string
    {
        $h = $seconds / 3600;
        $i = ($seconds % 3600) / 60;
        $s = $seconds % 60;

        if ($h >= 1) {
            return sprintf('%d:%02d:%02d', $h, $i, $s);
        }
        return sprintf('%d:%02d', $i, $s);
    }

    public static function getContentIdFromUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $seg = explode('/', $path);
        return array_pop($seg);
    }

    /**
     * @link https://qiita.com/yasumodev/items/74a73ed4b3f1dd45edb8
     * @return array<mixed>
     */
    public static function xmlToJson(string $xml): array
    {
        $xml = preg_replace("/<([^>]+?):([^>]+?)>/", "<$1_$2>", $xml);
        $xml = preg_replace("/_\/\//", "://", $xml);
        $objXml = simplexml_load_string($xml, null, LIBXML_NOCDATA);
        $json = json_encode($objXml, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return json_decode(preg_replace('/\\\\\//', '/', $json), true);
    }
}
