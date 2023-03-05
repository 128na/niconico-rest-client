<?php

declare(strict_types=1);

namespace Tests\ApiExt;

use NicoNicoRestClient\Helper\Functions;
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }


    /**
     * @dataProvider dataValidFormat
     */
    public function testTimeStringToSeconds(string $timeStr, int $seconds)
    {
        $actual = Functions::timeStringToSeconds($timeStr);
        $this->assertEquals($seconds, $actual, "$timeStr => $seconds");
    }

    /**
     * @dataProvider dataValidFormat
     */
    public function testSecondsToTimeString(string $timeStr, int $seconds)
    {
        $actual = Functions::secondsToTimeString($seconds);
        $this->assertEquals($timeStr, $actual, "$seconds => $timeStr");
    }

    public static function dataValidFormat()
    {
        return [
            ['0:00', 0],
            ['0:01', 1],
            ['1:01', 61],
            ['1:00:00', 3600],
            ['100:00:00', 360000],
        ];
    }

    /**
     * @dataProvider dataValidFormat
     */
    public function testGetContentIdFromUrl(string $timeStr, int $seconds)
    {
        $actual = Functions::secondsToTimeString($seconds);
        $this->assertEquals($timeStr, $actual, "$seconds => $timeStr");
    }
}
