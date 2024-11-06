<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;
use App\Console\Traits\EncryptionHelpers;

class decrypt extends Command
{
    use EncryptionHelpers;
    protected $signature = 'app:decrypt 
        {--file= : 从文件读取密文}';
    protected $description = '使用自定义16进制密钥解密密文';

    public function handle()
    {
        $this->info('=== 解密工具 ===');

        // 获取密文
        $encryptedValue = $this->getEncryptedValue();
        if (empty($encryptedValue)) {
            $this->error('没有输入任何内容，操作取消');
            return;
        }

        $this->info('=== 您输入的密文 ===');
        $this->info($encryptedValue);
        $this->newLine();

        // 获取密钥
        $hexKey = $this->askForHexKey();
        if (!$hexKey) return;
        $this->newLine();

        try {
            $decryptedValue = $this->decrypt_with_hex_key($hexKey, $encryptedValue);
            $this->newLine();
            $this->info('=== 解密结果 start ===');
            $this->info($decryptedValue);
            $this->info('=== 解密结果  end  ===');
            $this->newLine();
        } catch (DecryptException $e) {
            $this->error('解密失败：无效的加密字符串或密钥不匹配。');
        } catch (\Exception $e) {
            $this->error('解密过程中发生错误：' . $e->getMessage());
        }
        $this->info('解密完成');
        $this->newLine();
    }

    protected function getEncryptedValue()
    {
        // 1. 检查是否提供了文件选项
        $filePath = $this->option('file');
        if ($filePath) {
            if (!file_exists($filePath)) {
                $this->error("文件不存在: {$filePath}");
                $this->info('提示：文件路径可以是绝对路径或相对路径');
                $this->info('绝对路径示例：/Users/username/Desktop/encrypted.txt');
                $this->info('相对(项目根目录)路径示例：./encrypted.txt 或 encrypted.txt');
                return null;
            }
            return trim(file_get_contents($filePath));
        }

        // 2. 使用交互式输入
        $this->info('注意：密文应该是一个单行的 base64 文本。');
        $this->info('提示：如果密文较长，可以使用以下方式：');
        $this->info('--file 从文件读取密文，支持绝对路径或相对路径');
        $this->info('示例：');
        $this->info('  php artisan app:decrypt --file=./encrypted.txt');
        $this->info('  php artisan app:decrypt --file=/Users/username/Desktop/encrypted.txt');
        $this->newLine();
        return $this->ask('请输入要解密的字符串(密文)');
    }
}
