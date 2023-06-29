<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-26 15:48
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist;

class TimeHelper
{

    /**
     * 毫秒
     * 1 秒（s）= 1,000 毫秒（ms）
     *
     * @return int
     */
    public static function Milliseconds(): int
    {
        return (int)round(microtime(true) * 1000);
    }

    /**
     * 微秒
     * 1 秒（s）= 1,000 毫秒（ms）= 1,000,000 微秒（µs）
     *
     * @return int
     */
    public static function Microseconds(): int
    {
        return (int)round(microtime(true) * 1000 * 1000);
    }

    /**
     * 纳秒
     * 1 秒（s）= 1,000 毫秒（ms）= 1,000,000 微秒（µs）= 1,000,000,000 纳秒（ns）
     *
     * @return int
     */
    public static function Nanoseconds(): int
    {
        return (int)hrtime(true);
    }

    /**
     * 返回可读性较好的时间
     *
     * @param int $seconds 秒数
     * @return string
     */
    public static function humanTime(int $seconds): string
    {
        if ($seconds < 3600) {
            return ceil($seconds / 60) . '分';
        }

        if ($seconds < 3600 * 24) {
            return ceil($seconds / 3600) . '小时';
        }

        if ($seconds < 3600 * 24 * 365) {
            return ceil($seconds / (3600 * 24)) . '天';
        }

        return ceil($seconds / (3600 * 24 * 365)) . '年';
    }

}