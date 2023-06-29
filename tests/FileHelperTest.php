<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-29 17:38
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist\Tests;

use PHPUnit\Framework\TestCase;
use Pudongping\SmartAssist\FileHelper;

class FileHelperTest extends TestCase
{

    public function testHumanFileSize()
    {
        $this->assertSame('100.02kB', FileHelper::humanFileSize(102419));
        $this->assertSame('9.77MB', FileHelper::humanFileSize(10241922));
        $this->assertSame('9.54GB', FileHelper::humanFileSize(10241922345));
        $this->assertSame('9.31TB', FileHelper::humanFileSize(10241922345781));
    }

}