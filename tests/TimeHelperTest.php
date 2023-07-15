<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-07-15 17:47
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist\Tests;

use PHPUnit\Framework\TestCase;
use Pudongping\SmartAssist\TimeHelper;

class TimeHelperTest extends TestCase
{

    //  ./vendor/bin/phpunit --filter testMilliseconds
    public function testMilliseconds()
    {
        $milliseconds = TimeHelper::Milliseconds();

        $this->assertIsInt($milliseconds);
    }

    //  ./vendor/bin/phpunit --filter testMicroseconds
    public function testMicroseconds()
    {
        $microseconds = TimeHelper::Microseconds();

        $this->assertIsInt($microseconds);
    }

    //  ./vendor/bin/phpunit --filter testNanoseconds
    public function testNanoseconds()
    {
        $nanoseconds = TimeHelper::Nanoseconds();

        $this->assertIsInt($nanoseconds);
    }

    //  ./vendor/bin/phpunit --filter testHumanTime
    public function testHumanTime()
    {
        $seconds1 = 30;
        $seconds2 = 90;
        $seconds3 = 3600;
        $seconds4 = 86400;
        $seconds5 = 31536000;

        $humanTime1 = TimeHelper::humanTime($seconds1);
        $humanTime2 = TimeHelper::humanTime($seconds2);
        $humanTime3 = TimeHelper::humanTime($seconds3);
        $humanTime4 = TimeHelper::humanTime($seconds4);
        $humanTime5 = TimeHelper::humanTime($seconds5);

        $this->assertEquals('1分', $humanTime1);
        $this->assertEquals('2分', $humanTime2);
        $this->assertEquals('1小时', $humanTime3);
        $this->assertEquals('1天', $humanTime4);
        $this->assertEquals('1年', $humanTime5);
    }

}
