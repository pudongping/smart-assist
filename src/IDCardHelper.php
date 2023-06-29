<?php
/**
 * 身份证相关助手函数
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-29 13:38
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist;

class IDCardHelper
{

    /**
     * 十七位数字本体码权重
     *
     * @var int[]
     */
    private static $weight = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];

    /**
     * mod11, 对应校验码字符值
     *
     * @var string[]
     */
    private static $validate = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];

    /**
     * 验证出生日期是否合法
     *
     * @param string $year 年
     * @param string $month 月
     * @param string $day 日
     * @return bool
     */
    public static function isChinaIDCardDate(string $year, string $month, string $day): bool
    {
        $date = $year . '-' . $month . '-' . $day;
        $rPattern = '/^(([0-9]{2})|(19[0-9]{2})|(20[0-9]{2}))-((0[1-9]{1})|(1[012]{1}))-((0[1-9]{1})|(1[0-9]{1})|(2[0-9]{1})|3[01]{1})$/';

        if (preg_match($rPattern, $date, $arr)) {
            return true;
        }

        return false;
    }

    /**
     * 根据身份证号前 17 位，算出识别码
     *
     * @param string $id
     * @return string
     */
    public static function getValidateCode(string $id): string
    {
        $id17 = mb_substr($id, 0, 17);
        $sum = 0;
        $len = mb_strlen($id17);
        for ($i = 0; $i < $len; $i++) {
            $sum += $id17[$i] * self::$weight[$i];
        }
        $mode = $sum % 11;
        return self::$validate[$mode];
    }

    /**
     * 验证身份证号
     *
     * @param string $id 身份证号
     * @param bool $ban15 是否禁止验证 15 位身份证号
     * @return bool
     */
    public static function isChinaIDCard(string $id, bool $ban15 = true): bool
    {
        $len = mb_strlen($id);
        if ($ban15 && $len <= 15) {
            return false;
        }

        if ($len == 18) {
            if (! self::isChinaIDCardDate(mb_substr($id, 6, 4), mb_substr($id, 10, 2), mb_substr($id, 12, 2))) {
                return false;
            }

            $code = self::getValidateCode($id);
            if (strtoupper($code) == mb_substr($id, 17, 1)) {
                return true;
            }

            return false;
        } else if ($len == 15) {
            if (! self::isChinaIDCardDate('19' . mb_substr($id, 6, 2), mb_substr($id, 8, 2), mb_substr($id, 10, 2))) {
                return false;
            }

            if (! is_numeric($id)) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * 根据身份证号，自动返回对应的性别
     *
     * @param string $id 身份证号码
     * @return int 1 ==> 男，0 ==> 女
     */
    public static function getChinaIDCardSex(string $id): int
    {
        $sexInt = (int)mb_substr($id, 16, 1);
        return $sexInt % 2 === 0 ? 0 : 1;
    }

    /**
     * 根据身份证号码，返回对应的星座
     *
     * @param string $id 身份证号码
     * @return string  星座
     */
    public static function getConstellationByChinaIDCard(string $id): string
    {
        $bir = mb_substr($id, 10, 4);
        $month = (int)mb_substr($bir, 0, 2);
        $day = (int)mb_substr($bir, 2);

        $strValue = '';
        if (($month == 1 && $day <= 21) || ($month == 2 && $day <= 19)) {
            $strValue = '水瓶座';
        } elseif (($month == 2 && $day > 20) || ($month == 3 && $day <= 20)) {
            $strValue = '双鱼座';
        } elseif (($month == 3 && $day > 20) || ($month == 4 && $day <= 20)) {
            $strValue = '白羊座';
        } elseif (($month == 4 && $day > 20) || ($month == 5 && $day <= 21)) {
            $strValue = '金牛座';
        } elseif (($month == 5 && $day > 21) || ($month == 6 && $day <= 21)) {
            $strValue = '双子座';
        } elseif (($month == 6 && $day > 21) || ($month == 7 && $day <= 22)) {
            $strValue = '巨蟹座';
        } elseif (($month == 7 && $day > 22) || ($month == 8 && $day <= 23)) {
            $strValue = '狮子座';
        } elseif (($month == 8 && $day > 23) || ($month == 9 && $day <= 23)) {
            $strValue = '处女座';
        } elseif (($month == 9 && $day > 23) || ($month == 10 && $day <= 23)) {
            $strValue = '天秤座';
        } elseif (($month == 10 && $day > 23) || ($month == 11 && $day <= 22)) {
            $strValue = '天蝎座';
        } elseif (($month == 11 && $day > 22) || ($month == 12 && $day <= 21)) {
            $strValue = '射手座';
        } elseif (($month == 12 && $day > 21) || ($month == 1 && $day <= 20)) {
            $strValue = '魔羯座';
        }

        return $strValue;
    }

    /**
     * 根据身份证号码，返回对应的生肖
     *
     * @param string $id
     * @return string
     */
    public static function getChineseZodiacByChinaIDCard(string $id): string
    {
        $start = 1901;
        $end = (int)mb_substr($id, 6, 4);
        $x = ($start - $end) % 12;

        if ($x == 1 || $x == -11) {
            return '鼠';
        }
        if ($x == 0) {
            return '牛';
        }
        if ($x == 11 || $x == -1) {
            return '虎';
        }
        if ($x == 10 || $x == -2) {
            return '兔';
        }
        if ($x == 9 || $x == -3) {
            return '龙';
        }
        if ($x == 8 || $x == -4) {
            return '蛇';
        }
        if ($x == 7 || $x == -5) {
            return '马';
        }
        if ($x == 6 || $x == -6) {
            return '羊';
        }
        if ($x == 5 || $x == -7) {
            return '猴';
        }
        if ($x == 4 || $x == -8) {
            return '鸡';
        }
        if ($x == 3 || $x == -9) {
            return '狗';
        }
        if ($x == 2 || $x == -10) {
            return '猪';
        }

        return '';
    }

}