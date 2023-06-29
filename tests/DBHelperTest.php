<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-29 17:55
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist\Tests;

use PHPUnit\Framework\TestCase;
use Pudongping\SmartAssist\DBHelper;

class DBHelperTest extends TestCase
{

    public function testBatchUpdateCaseWhen()
    {
        $where = [ 'id' => [180, 181, 182, 183], 'user_id' => [5, 15, 11, 1]];
        $needUpdateFields = [ 'view_count' => [11, 22, 33, 44], 'updated_at' => ['2019-11-06 06:44:58', '2019-11-30 19:59:34', '2019-11-05 11:58:41', '2019-12-13 01:27:59']];

        $test1 = DBHelper::batchUpdateCaseWhen('articles', $where, $needUpdateFields);
        $guest = [
            'query' => 'UPDATE articles SET view_count = CASE  WHEN id = ? AND user_id = ? THEN ?  WHEN id = ? AND user_id = ? THEN ?  WHEN id = ? AND user_id = ? THEN ?  WHEN id = ? AND user_id = ? THEN ?  ELSE view_count END, updated_at = CASE  WHEN id = ? AND user_id = ? THEN ?  WHEN id = ? AND user_id = ? THEN ?  WHEN id = ? AND user_id = ? THEN ?  WHEN id = ? AND user_id = ? THEN ?  ELSE updated_at END',
            'bindings' => [180, 5, 11, 181, 15, 22, 182, 11, 33, 183, 1, 44, 180, 5, '2019-11-06 06:44:58', 181, 15, '2019-11-30 19:59:34', 182, 11, '2019-11-05 11:58:41', 183, 1, '2019-12-13 01:27:59']
        ];

        $this->assertEquals($guest, $test1);
    }

    public function testUpsert()
    {
        $tableName = 'my_table';
        $data = [
            [1, 'Tom', 20, 'male'],
            [2, 'Jerry', 25, 'female'],
            [3, 'Alice', 30, 'male'],
            [4, 'Bob', 35, 'female'],
        ];
        $columns = ['id', 'name', 'age', 'sex'];

        $test1 = DBHelper::upsert($tableName, $data, $columns);

        $guest = [
            'query' => 'INSERT INTO my_table (id,name,age,sex) VALUES (?,?,?,?),(?,?,?,?),(?,?,?,?),(?,?,?,?) ON DUPLICATE KEY UPDATE name = VALUES(name),age = VALUES(age),sex = VALUES(sex)',
            'bindings' => [1, 'Tom', 20, 'male', 2, 'Jerry', 25, 'female', 3, 'Alice', 30, 'male', 4, 'Bob', 35, 'female']
        ];

        $this->assertEquals($guest, $test1);
    }

}