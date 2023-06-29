<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-29 11:29
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist;

class FileHelper
{

    /**
     * 返回可读性更好的文件大小
     *
     * @param int $bytes 文件大小（字节数）
     * @param int $decimals 保留多少位数
     * @return string 带单位的文件大小字符串
     */
    public static function humanFileSize(int $bytes, int $decimals = 2): string
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
        // 舍去法取整
        $factor = floor((mb_strlen((string)$bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    /**
     * 确保文件或者目录存在且可写
     *
     * @param string $path
     * @param bool $isDir
     * @return bool
     */
    public static function sureWritableExists(string $path, bool $isDir = false): bool
    {
        if (file_exists($path)) {
            return is_writable($path);
        }

        $dir = $isDir ? $path : dirname($path);
        return ! file_exists($dir) && ! mkdir($dir, 0775, true) && ! is_dir($dir) ? false : is_writable($dir);
    }

}