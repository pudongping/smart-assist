<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-07-15 16:29
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist\Tests;

use PHPUnit\Framework\TestCase;
use Pudongping\SmartAssist\IDCardHelper;

class IDCardHelperTest extends TestCase
{

    //  ./vendor/bin/phpunit --filter testIsChinaIDCardDate
    public function testIsChinaIDCardDate()
    {
        // 有效日期
        $this->assertTrue(IDCardHelper::isChinaIDCardDate('1990', '01', '01'));
        $this->assertTrue(IDCardHelper::isChinaIDCardDate('2000', '02', '29'));
        $this->assertTrue(IDCardHelper::isChinaIDCardDate('1988', '12', '31'));
        $this->assertTrue(IDCardHelper::isChinaIDCardDate('1996', '02', '29'));

        // 无效日期
        $this->assertFalse(IDCardHelper::isChinaIDCardDate('2022', '13', '01'));
        $this->assertFalse(IDCardHelper::isChinaIDCardDate('2010', '04', '31'));
        $this->assertFalse(IDCardHelper::isChinaIDCardDate('1997', '02', '29')); // 非闰年不能有29号
    }

    // ./vendor/bin/phpunit --filter testGetValidateCode
    public function testGetValidateCode()
    {
        $id = '11010120000229363';
        $r1 = IDCardHelper::getValidateCode($id);
        $this->assertEquals('0', $r1);

        $id = '32058319900101001';
        $r1 = IDCardHelper::getValidateCode($id);
        $this->assertEquals('0', $r1);


        $id = '42010619851231410';
        $r1 = IDCardHelper::getValidateCode($id);
        $this->assertEquals('9', $r1);
    }

    // ./vendor/bin/phpunit --filter testIsChinaIDCard
    public function testIsChinaIDCard()
    {
        // 无效身份证号
        $this->assertFalse(IDCardHelper::isChinaIDCard('123'));
        $this->assertFalse(IDCardHelper::isChinaIDCard('320583199001010'));
    }

    // ./vendor/bin/phpunit --filter testGetChinaIDCardSex
    public function testGetChinaIDCardSex()
    {
        $maleID = '320583199001010016';
        $femaleID = '320583199001010027';

        $this->assertEquals(1, IDCardHelper::getChinaIDCardSex($maleID));
        $this->assertEquals(0, IDCardHelper::getChinaIDCardSex($femaleID));
    }

    // ./vendor/bin/phpunit --filter testGetConstellationByChinaIDCard
    public function testGetConstellationByChinaIDCard()
    {
        $id = '320583199001010016';
        $this->assertEquals('水瓶座', IDCardHelper::getConstellationByChinaIDCard($id));
    }

    // ./vendor/bin/phpunit --filter testGetChineseZodiacByChinaIDCard
    public function testGetChineseZodiacByChinaIDCard()
    {
        $id = '320583199201010016';
        $this->assertEquals('猴', IDCardHelper::getChineseZodiacByChinaIDCard($id));
    }

}
