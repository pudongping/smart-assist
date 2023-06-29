<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-29 16:44
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist\Tests;

use PHPUnit\Framework\TestCase;
use Pudongping\SmartAssist\ArrHelper;

class ArrHelperTest extends TestCase
{

    public function testSame()
    {
        $test1 = ArrHelper::same([1, 2, 5, 7], [5, 7, 1, 2]);
        $this->assertTrue($test1);
    }

    public function testSortByField()
    {
        $array = [
            ['id' => 1, 'score' => 9, 'name' => 'alex'],
            ['id' => 2, 'score' => 4, 'name' => 'pu'],
            ['id' => 3, 'score' => 7, 'name' => 'harry'],
            ['id' => 1, 'score' => 13, 'name' => 'petter'],
        ];

        $test1 = ArrHelper::sortByField($array, 'id');
        $this->assertEquals([
            ['id' => 3, 'score' => 7, 'name' => 'harry'],
            ['id' => 2, 'score' => 4, 'name' => 'pu'],
            ['id' => 1, 'score' => 9, 'name' => 'alex'],
            ['id' => 1, 'score' => 13, 'name' => 'petter'],
        ], $test1);
    }

    public function testGroupByField()
    {
        $array = [
            ['id' => 1, 'score' => 9, 'name' => 'alex'],
            ['id' => 2, 'score' => 4, 'name' => 'pu'],
            ['id' => 3, 'score' => 7, 'name' => 'harry'],
            ['id' => 1, 'score' => 13, 'name' => 'petter'],
        ];

        $test1 = ArrHelper::groupByField($array, 'id');
        $this->assertEquals([
            1 => [
                ['id' => 1, 'score' => 9, 'name' => 'alex'],
                ['id' => 1, 'score' => 13, 'name' => 'petter'],
            ],
            2 => [
                ['id' => 2, 'score' => 4, 'name' => 'pu'],
            ],
            3 => [
                ['id' => 3, 'score' => 7, 'name' => 'harry'],
            ],
        ], $test1);
    }

    public function testAddDataToNestedArray()
    {
        $data = [
            ['a' => 1, 'b' => 2],
            ['c' => 3, 'd' => 4]
        ];

        $extraData = [
            'hello' => 'world'
        ];

        $result = ArrHelper::addDataToNestedArray($data, $extraData);

        $guest = [
            ['a' => 1, 'b' => 2, 'hello' => 'world'],
            ['c' => 3, 'd' => 4, 'hello' => 'world']
        ];

        $this->assertSame($guest, $result);
    }

}