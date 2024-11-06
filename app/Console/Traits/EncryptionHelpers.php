<?php

namespace App\Console\Traits;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Encryption\Encrypter;

trait EncryptionHelpers
{
    protected function encrypt_with_hex_key($hexKey, $value)
    {
        $binKey = hex2bin($hexKey);

        // 创建 Encrypter 实例
        $encrypter = new Encrypter($binKey, config('app.cipher'));

        // 加密数据
        $encryptedValue = $encrypter->encrypt($value);
        return $encryptedValue;
    }

    protected function decrypt_with_hex_key($hexKey, $encryptedValue)
    {
        $binKey = hex2bin($hexKey);

        // 创建 Encrypter 实例
        $encrypter = new Encrypter($binKey, config('app.cipher'));

        // 解密数据
        $decryptedValue = $encrypter->decrypt($encryptedValue);
        return $decryptedValue;
    }

    protected function askForHexKey()
    {
        $key = $this->ask('请输入“长度为64的16进制的密钥”（32字节）');
        if (!ctype_xdigit($key) || strlen($key) !== 64) {
            $this->error('无效的16进制密钥。必须是64个16进制字符（32字节）。');
            return false;
        }
        return $key;
    }

    protected function generateHexKey()
    {
        return bin2hex(random_bytes(32));
    }
}