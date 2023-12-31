<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-07-15 17:32
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist\Tests;

use PHPUnit\Framework\TestCase;
use Pudongping\SmartAssist\StrHelper;

class StrHelperTest extends TestCase
{
    //  ./vendor/bin/phpunit --filter testGenRandomStr
    public function testGenRandomStr()
    {
        $length = 10;
        $type = 0;

        $randomStr = StrHelper::genRandomStr($length, $type);

        $this->assertEquals($length, mb_strlen($randomStr));
    }

    //  ./vendor/bin/phpunit --filter testGenRandomChineseWords
    public function testGenRandomChineseWords()
    {
        $num = 10;
        $result = StrHelper::genRandomChineseWords($num);

        // Assert that the result is a string
        $this->assertIsString($result);

        // Assert that the length of the result is equal to the given $num
        $this->assertEquals($num, mb_strlen($result, 'UTF-8'));

        // Assert that the result contains only valid Chinese characters (UTF-8)
        $this->assertMatchesRegularExpression('/^[\x{4e00}-\x{9fa5}]+$/u', $result);
    }

    // ./vendor/bin/phpunit --filter testGenUniqueNum
    public function testGenUniqueNum()
    {
        // Test for the default case (not using bigint)
        $result = StrHelper::genUniqueNum();
        $this->assertIsString($result);

        // Test for using bigint
        $resultBigint = StrHelper::genUniqueNum(true);
        $this->assertIsString($resultBigint);
    }

    //  ./vendor/bin/phpunit --filter testBase64UrlEncodeAndDecode
    public function testBase64UrlEncodeAndDecode()
    {
        $input = 'Hello, World!';

        $encoded = StrHelper::base64UrlEncode($input);
        $decoded = StrHelper::base64UrlDecode($encoded);

        $this->assertEquals($input, $decoded);
    }

    //  ./vendor/bin/phpunit --filter testHide
    public function testHide()
    {
        $string = '1234567890';

        $hidden1 = StrHelper::hide($string, 3, 4);
        $hidden2 = StrHelper::hide($string, -4, 3, '#');

        $this->assertEquals('123****890', $hidden1);
        $this->assertEquals('123456###0', $hidden2);
    }

    //  ./vendor/bin/phpunit --filter testFullOrHalfWidthTrans
    public function testFullOrHalfWidthTrans()
    {
        $input = 'ｈｅｌｌｏ　ｗｏｒｌｄ！';
        $input1 = 'hello world!';

        $converted = StrHelper::FullOrHalfWidthTrans($input, true);  // 半角
        $converted1 = StrHelper::FullOrHalfWidthTrans($converted);  // 全角
        $converted2 = StrHelper::FullOrHalfWidthTrans($converted1, true);  // 半角

        $this->assertEquals($input1, $converted);
        $this->assertEquals($converted, $converted2);
    }

}
