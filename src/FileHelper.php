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
     * 压缩文件或目录为zip格式
     *
     * @param string $source 源文件或目录的路径
     * @param string $zipFile 压缩后的zip文件路径
     * @return bool
     */
    public static function compressToZip(string $source, string $zipFile): bool
    {
        if (! file_exists($source)) {
            return false;
        }

        $zipDir = dirname($zipFile);
        if (! is_dir($zipDir)) {
            mkdir($zipDir, 0775, true);
        }

        $zip = new \ZipArchive();

        if (true !== $zip->open($zipFile, \ZipArchive::CREATE)) {
            return false;
        }

        if (is_dir($source)) {
            $source = rtrim($source, '/');
            $baseDir = basename($source);

            $iterator = new \RecursiveIteratorIterator(
            // 跳过 `.` 和 `..`
                new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $file) {
                $file = $file->getPathname();

                if (is_dir($file)) {
                    $zip->addEmptyDir($baseDir . '/' . mb_substr($file, strlen($source) + 1));
                } elseif (is_file($file)) {
                    $zip->addFile($file, $baseDir . '/' . mb_substr($file, strlen($source) + 1));
                }
            }

        } elseif (is_file($source)) {
            $zip->addFile($source, basename($source));
        }

        $zip->close();

        return true;
    }

    /**
     * 解压zip文件，包含多级目录和任意文件
     *
     * @param string $zipFile 需要解压的文件路径加文件名
     * @param string $toDir 解压后的文件夹路径
     * @return bool
     */
    public static function extractZipToDir(string $zipFile, string $toDir): bool
    {
        if (! file_exists($zipFile)) {
            return false;
        }

        $zip = new \ZipArchive();

        if (true !== $zip->open($zipFile)) {
            return false;
        }

        if (! is_dir($toDir)) {
            mkdir($toDir, 0775, true);
        }

        $zip->extractTo($toDir);
        $zip->close();

        return true;
    }

    /**
     * 复制目录
     *
     * @param string $source 源目录
     * @param string $destination 目标目录
     * @return bool
     */
    public static function copyDir(string $source, string $destination): bool
    {
        if (! file_exists($source) || ! is_dir($source)) {
            return false;
        }

        if (! is_dir($destination)) {
            mkdir($destination, 0775, true);
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $sourcePath = $item->getPathname();
            $destinationPath = $destination . '/' . $iterator->getSubPathName();

            if ($item->isDir()) {
                if (! is_dir($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }
            } else {
                copy($sourcePath, $destinationPath);
            }

        }

        return true;
    }

}