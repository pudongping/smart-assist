<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-26 16:18
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist;

class CipherHelper
{

    /**
     * aes cbc 加密
     *
     * @param mixed $plaintext 明文
     * @param string $key 加密 key
     * @param string $iv 向量
     * @return string
     */
    public static function AESCBCEncrypt($plaintext, string $key, string $iv = ''): string
    {
        if ($iv == '') $iv = mb_substr($key, 0, 16);
        $jsonPlaintext = json_encode($plaintext, 256);
        $encrypted = openssl_encrypt($jsonPlaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($encrypted);
    }

    /**
     * aes cbc 解密
     *
     * @param string $encrypted 密文
     * @param string $key 解密 key
     * @param string $iv 向量
     * @return array
     */
    public static function AESCBCDecrypt(string $encrypted, string $key, string $iv = ''): array
    {
        if ($iv == '') $iv = mb_substr($key, 0, 16);
        $str = base64_decode($encrypted);
        $decrypted = openssl_decrypt($str, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        if (! $decrypted) {
            return [];
        }
        return json_decode($decrypted, true) ?: [];
    }

}