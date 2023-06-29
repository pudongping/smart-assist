<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-25 18:51
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist;

class StrHelper
{

    /**
     * 生成随机字符串
     *
     * @param int $len 所需要生成的长度
     * @param int $type 生成类型
     * @return string 生成后的字符串
     */
    public static function genRandomStr(int $len = 16, int $type = 0): string
    {
        $str1 = 'abcdefghijklmnopqrstuvwxyz';
        $str2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str3 = '0123456789';

        $strArr = [
            $str1,
            $str2,
            $str3,
            $str1 . $str2,
            $str1 . $str3,
            $str2 . $str3,
            $str1 . $str2 . $str3
        ];
        $str = $strArr[$type];
        $l = strlen($str) - 1;

        $randStr = '';
        for ($i = 0; $i < $len; $i++) {
            $randStr .= $str[mt_rand(0, $l)];
        }

        return $randStr;
    }

    /**
     * Base 64 Encoding with URL and Filename Safe Alphabet
     * https://datatracker.ietf.org/doc/html/rfc4648#page-7
     *
     * @param string $input
     * @return string
     */
    public static function base64UrlEncode(string $input): string
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    /**
     * @param string $input
     * @return false|string
     */
    public static function base64UrlDecode(string $input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * 脱敏函数
     * 将一个字符串部分字符用 $re 替代隐藏
     *
     * @param string $string 待处理的字符串
     * @param int $start 规定在字符串的何处开始，
     *                            正数 - 在字符串的指定位置开始
     *                            负数 - 在从字符串结尾的指定位置开始
     *                            0 - 在字符串中的第一个字符处开始
     * @param int $length 可选。规定要隐藏的字符串长度。默认是直到字符串的结尾。
     *                            正数 - 从 start 参数所在的位置隐藏
     *                            负数 - 从字符串末端隐藏
     * @param string $re 替代符
     *
     * @return string   处理后的字符串
     */
    public static function hide($string, $start = 0, $length = 0, $re = '*'): string
    {
        if (empty($string)) return $string;

        $strArray = [];
        $mbStrLength = mb_strlen($string);
        while ($mbStrLength) {  // 循环把字符串变为数组
            $strArray[] = mb_substr($string, 0, 1, 'utf8');
            $string = mb_substr($string, 1, $mbStrLength, 'utf8');
            $mbStrLength = mb_strlen($string);
        }
        $strLength = count($strArray);
        $begin = $start >= 0 ? $start : ($strLength - abs($start));
        $end = $last = $strLength - 1;
        if ($length > 0) {
            $end = $begin + $length - 1;
        } else if ($length < 0) {
            $end -= abs($length);
        }
        for ($i = $begin; $i <= $end; $i++) {
            $strArray[$i] = $re;
        }
        if ($begin >= $end || $begin >= $last || $end > $last) {
            return $string;
        }

        return implode('', $strArray);
    }

    /**
     * 字符串全角和半角之间的转换
     *
     * @param string $str 需要转换的字符串
     * @param bool $isFullToHalf true 全角转半角 false 半角转全角
     * @return array|string|string[]
     */
    public static function FullOrHalfWidthTrans(string $str, bool $isFullToHalf = false)
    {
        $dbc = [
            '０', '１', '２', '３', '４',
            '５', '６', '７', '８', '９',
            'Ａ', 'Ｂ', 'Ｃ', 'Ｄ', 'Ｅ',
            'Ｆ', 'Ｇ', 'Ｈ', 'Ｉ', 'Ｊ',
            'Ｋ', 'Ｌ', 'Ｍ', 'Ｎ', 'Ｏ',
            'Ｐ', 'Ｑ', 'Ｒ', 'Ｓ', 'Ｔ',
            'Ｕ', 'Ｖ', 'Ｗ', 'Ｘ', 'Ｙ',
            'Ｚ', 'ａ', 'ｂ', 'ｃ', 'ｄ',
            'ｅ', 'ｆ', 'ｇ', 'ｈ', 'ｉ',
            'ｊ', 'ｋ', 'ｌ', 'ｍ', 'ｎ',
            'ｏ', 'ｐ', 'ｑ', 'ｒ', 'ｓ',
            'ｔ', 'ｕ', 'ｖ', 'ｗ', 'ｘ',
            'ｙ', 'ｚ', '！', '？', '（',
            '）', '［', '］', '＜', '＞',
            '＆', '：', '＊', '−', '＋',
            '／', '＃', '｜', '“', '”',
            '，', '％', '＿', '＠', '＝',
            '　',
        ];

        $sbc = [
            '0', '1', '2', '3', '4',
            '5', '6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E',
            'F', 'G', 'H', 'I', 'J',
            'K', 'L', 'M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T',
            'U', 'V', 'W', 'X', 'Y',
            'Z', 'a', 'b', 'c', 'd',
            'e', 'f', 'g', 'h', 'i',
            'j', 'k', 'l', 'm', 'n',
            'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x',
            'y', 'z', '!', '?', '(',
            ')', '[', ']', '<', '>',
            '&', ':', '*', '-', '+',
            '/', '#', '|', '"', '"',
            ',', '%', '_', '@', '=',
            ' ',
        ];

        return $isFullToHalf
            ? str_replace($dbc, $sbc, $str)  // 全角转半角
            : str_replace($sbc, $dbc, $str);  // 半角转全角
    }

}