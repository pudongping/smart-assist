<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2023-06-29 17:46
 */
declare(strict_types=1);

namespace Pudongping\SmartAssist\Tests;

use PHPUnit\Framework\TestCase;
use Pudongping\SmartAssist\CipherHelper;

class CipherHelperTest extends TestCase
{

    public function testAESCBCEncrypt()
    {
        $arr = [
            'name' => 'alex',
            'age' => 18
        ];

        $key = '1234567890987654';

        $encrypted = CipherHelper::AESCBCEncrypt($arr, $key);

        $this->assertSame('1H1U2nhbYvlPhSQ/tUj2YcQj6/QM5ZqKkvdMEFwmiW0=', $encrypted);

        $plaintext = CipherHelper::AESCBCDecrypt($encrypted, $key);

        $this->assertEquals($arr, $plaintext);
    }

}