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

    //  ./vendor/bin/phpunit --filter testHumanFileSize
    public function testHumanFileSize()
    {
        $this->assertSame('875.00B', FileHelper::humanFileSize(875));
        $this->assertSame('100.02kB', FileHelper::humanFileSize(102419));
        $this->assertSame('9.77MB', FileHelper::humanFileSize(10241922));
        $this->assertSame('9.54GB', FileHelper::humanFileSize(10241922345));
        $this->assertSame('9.31TB', FileHelper::humanFileSize(10241922345781));
        $this->assertSame('90.97PB', FileHelper::humanFileSize(102419223457817321));
    }

    // ./vendor/bin/phpunit --filter testCompressToZip
    public function testCompressToZip()
    {
        $path = __DIR__ . '/../';
        $source = $path . 'tests';
        $zipFile = $path . 'tt/abc/tests.zip';

        $this->assertTrue(is_dir($source));
        $this->assertTrue(FileHelper::compressToZip($source, $zipFile));
        $this->assertFileExists($zipFile);
    }

    // ./vendor/bin/phpunit --filter testExtractZipToDir
    public function testExtractZipToDir()
    {
        $path = __DIR__ . '/../';
        $zipFile = $path . 'tt/abc/tests.zip';
        $toDir = $path . 'tt/abc/hello';

        $this->assertFileExists($zipFile);
        $this->assertTrue(FileHelper::extractZipToDir($zipFile, $toDir));
        $this->assertDirectoryExists($toDir);
    }

    //  ./vendor/bin/phpunit --filter testCopyDir
    public function testCopyDir()
    {
        $path = __DIR__ . '/../';

        // Test copying a directory
        $sourceDir = $path . 'tests';
        $destDir = $path . 'aa';
        FileHelper::copyDir($sourceDir, $destDir);

        $this->assertDirectoryExists($destDir);
        $this->assertFileExists($destDir . '/FileHelperTest.php');
    }

}