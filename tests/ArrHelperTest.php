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

    //  ./vendor/bin/phpunit --filter testSame
    public function testSame()
    {
        $test1 = ArrHelper::same([1, 2, 5, 7], [5, 7, 1, 2]);
        $this->assertTrue($test1);

        $test2 = ArrHelper::same([1, 2, 5, 7], [5, 7, 1, 2], true);
        $this->assertFalse($test2);

        $test3 = ArrHelper::same([1, 2, 5, 7], [1, 2, 5, 7], true);
        $this->assertTrue($test3);

        $test4 = ArrHelper::same(
            [
                'name1' => 'alex',
                'age' => 18,
                'score' => 100
            ],
            [
                'age' => 18,
                'name' => 'alex',
                'score' => 100
            ],
        );
        $this->assertTrue($test4);

        $test5 = ArrHelper::same(
            [
                'name' => 'alex',
                'age' => 18,
                'score' => 100
            ],
            [
                'age' => 18,
                'name' => 'alex',
                'score' => 100
            ],
            true
        );
        $this->assertTrue($test5);

    }

    //  ./vendor/bin/phpunit --filter testSortByField
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

        $test2 = ArrHelper::sortByField($array, 'name', SORT_ASC, SORT_STRING);
        $this->assertEquals([
            ['id' => 1, 'score' => 9, 'name' => 'alex'],
            ['id' => 3, 'score' => 7, 'name' => 'harry'],
            ['id' => 1, 'score' => 13, 'name' => 'petter'],
            ['id' => 2, 'score' => 4, 'name' => 'pu'],
        ], $test2);

    }

    //  ./vendor/bin/phpunit --filter testGroupByField
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

        $test2 = ArrHelper::groupByField($array, 'name');
        $this->assertEquals([
            'alex' => [
                ['id' => 1, 'score' => 9, 'name' => 'alex']
            ],
            'pu' => [
                ['id' => 2, 'score' => 4, 'name' => 'pu']
            ],
            'harry' => [
                ['id' => 3, 'score' => 7, 'name' => 'harry']
            ],
            'petter' => [
                ['id' => 1, 'score' => 13, 'name' => 'petter']
            ],
        ], $test2);
    }

    //  ./vendor/bin/phpunit --filter testAddDataToNestedArray
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

    //  ./vendor/bin/phpunit --filter testMinIntElement
    public function testMinIntElement()
    {
        $data = [
            ['name' => 'alex', 'age' => 18],
            ['name' => 'alex1', 'age' => 28],
            ['name' => 'alex2', 'age' => 23],
            ['name' => 'alex3', 'age' => 18],
            ['name' => 'alex4', 'age' => 18],
            ['name' => 'alex5', 'age' => 28],
            ['name' => 'alex6', 'age' => 20],
        ];

        $t1 = ArrHelper::minIntElement($data, 'age');
        $this->assertSame(
            ['name' => 'alex', 'age' => 18],
            $t1
        );

        $t2 = ArrHelper::minIntElement($data, 'age', false);
        $this->assertSame(
            ['name' => 'alex4', 'age' => 18],
            $t2
        );
    }

    //  ./vendor/bin/phpunit --filter testMaxIntElement
    public function testMaxIntElement()
    {
        $data = [
            ['name' => 'alex', 'age' => 18],
            ['name' => 'alex1', 'age' => 28],
            ['name' => 'alex2', 'age' => 23],
            ['name' => 'alex3', 'age' => 18],
            ['name' => 'alex4', 'age' => 18],
            ['name' => 'alex5', 'age' => 28],
            ['name' => 'alex6', 'age' => 20],
        ];

        $t1 = ArrHelper::maxIntElement($data, 'age');
        $this->assertSame(
            ['name' => 'alex1', 'age' => 28],
            $t1
        );

        $t2 = ArrHelper::maxIntElement($data, 'age', false);
        $this->assertSame(
            ['name' => 'alex5', 'age' => 28],
            $t2
        );
    }

    public function testToTree()
    {
        // 测试空数组作为输入
        $this->assertEquals([], ArrHelper::toTree([]));

        // 测试基本二维数组转换成树型结构
        $inputArray = [
            ['id' => 1, 'name' => 'A', 'pid' => 0],
            ['id' => 2, 'name' => 'B', 'pid' => 0],
            ['id' => 3, 'name' => 'A-1', 'pid' => 1],
            ['id' => 4, 'name' => 'A-2', 'pid' => 1],
            ['id' => 5, 'name' => 'B-1', 'pid' => 2],
        ];

        $expectedResult = [
            ['id' => 1, 'name' => 'A', 'pid' => 0, 'children' => [
                ['id' => 3, 'name' => 'A-1', 'pid' => 1, 'children' => []],
                ['id' => 4, 'name' => 'A-2', 'pid' => 1, 'children' => []],
            ]],
            ['id' => 2, 'name' => 'B', 'pid' => 0, 'children' => [
                ['id' => 5, 'name' => 'B-1', 'pid' => 2, 'children' => []],
            ]],
        ];

        $this->assertEquals($expectedResult, ArrHelper::toTree($inputArray));

        // 测试树中的子节点为空
        $inputArray2 = [
            ['id' => 1, 'name' => 'A', 'pid' => 0],
            ['id' => 2, 'name' => 'B', 'pid' => 1],
            ['id' => 3, 'name' => 'C', 'pid' => 2],
        ];

        $expectedResult2 = [
            ['id' => 1, 'name' => 'A', 'pid' => 0, 'children' => [
                ['id' => 2, 'name' => 'B', 'pid' => 1, 'children' => [
                    ['id' => 3, 'name' => 'C', 'pid' => 2, 'children' => []],
                ]],
            ]],
        ];

        $this->assertEquals($expectedResult2, ArrHelper::toTree($inputArray2));

        // 测试更多层级的数据
        $inputArray3 = [
            ['id' => 1, 'name' => 'A', 'pid' => 0],
            ['id' => 2, 'name' => 'B', 'pid' => 0],
            ['id' => 3, 'name' => 'A-1', 'pid' => 1],
            ['id' => 4, 'name' => 'A-1-1', 'pid' => 3],
            ['id' => 5, 'name' => 'A-1-2', 'pid' => 3],
            ['id' => 6, 'name' => 'A-2', 'pid' => 1],
            ['id' => 7, 'name' => 'A-2-1', 'pid' => 6],
            ['id' => 8, 'name' => 'B-1', 'pid' => 2],
        ];

        $expectedResult3 = [
            ['id' => 1, 'name' => 'A', 'pid' => 0, 'children' => [
                ['id' => 3, 'name' => 'A-1', 'pid' => 1, 'children' => [
                    ['id' => 4, 'name' => 'A-1-1', 'pid' => 3, 'children' => []],
                    ['id' => 5, 'name' => 'A-1-2', 'pid' => 3, 'children' => []],
                ]],
                ['id' => 6, 'name' => 'A-2', 'pid' => 1, 'children' => [
                    ['id' => 7, 'name' => 'A-2-1', 'pid' => 6, 'children' => []],
                ]],
            ]],
            ['id' => 2, 'name' => 'B', 'pid' => 0, 'children' => [
                ['id' => 8, 'name' => 'B-1', 'pid' => 2, 'children' => []],
            ]],
        ];

        $this->assertEquals($expectedResult3, ArrHelper::toTree($inputArray3));
    }

}