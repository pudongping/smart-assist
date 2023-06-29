<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-25 18:52
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist;

class ArrHelper
{

    /**
     * 检查两个数组元素是否相同（真子集）
     *
     * @param array $arr1 数组1
     * @param array $arr2 数组2
     * @param bool $assoc 是否带索引检查
     * @return bool arr1 和 arr2 中所有的元素都有（arr1 包含 arr2，arr2 也包含 arr1）则为 true，否则为 false
     */
    public static function same(array $arr1, array $arr2, bool $assoc = false): bool
    {
        return $assoc
            ? (! array_diff_assoc($arr1, $arr2) && ! array_diff_assoc($arr2, $arr1))
            : (! array_diff($arr1, $arr2) && ! array_diff($arr2, $arr1));
    }

    /**
     * 对数组根据指定字段进行排序
     *
     * @param array $array 原始的数组
     * @param string $key 二维数组中的某个键名
     * @param int $sort 排序方式，默认以[倒序]的形式进行排序
     * @param int $sortRule 排序规则，默认以[数值]的形式进行排序
     * @return array
     */
    public static function sortByField(array $array, string $key, int $sort = SORT_DESC, int $sortRule = SORT_NUMERIC): array
    {
        if (empty($array)) return [];
        $valArr = array_values($array);
        $keys = array_column($valArr, $key);
        if (empty($keys)) return [];

        $new = $valArr;  // 防止莫名的情况影响原始的多维数组数据
        array_multisort($keys, $sort, $sortRule, $new);

        return $new;
    }

    /**
     * 对数组中指定字段的值进行分组
     *
     * @param array $array 原始的数组
     * @param string $key 二维数组中的某个键名
     * @return array
     */
    public static function groupByField(array $array, string $key): array
    {
        $result = [];

        foreach ($array as $item) {
            if (isset($item[$key])) {
                $result[$item[$key]][] = $item;
            }
        }

        return $result;
    }

    /**
     * 对二维数组增加同一项数据
     *
     * @param array $data 原始数组
     * @param array $extraData 需要增加的项
     * @return array
     */
    public static function addDataToNestedArray(array $data, array $extraData): array
    {
        return array_map(function ($item) use ($extraData) {
            return array_merge($item, $extraData);
        }, $data);
    }

}
