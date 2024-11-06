<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use App\Console\Traits\EncryptionHelpers;

class encrypt extends Command
{
    use EncryptionHelpers;
    protected $signature = 'app:encrypt';
    protected $description = '使用自定义16进制密钥加密多行输入的字符串';

    public function handle()
    {
        $this->info('=== 自定义16进制密钥多行文本加密工具 ===');

        $keyChoice = $this->choice(
            '请选择密钥选项',
            [
                '输入自定义的"长度为64的16进制的密钥"',
                '生成新的随机"长度为64的16进制的密钥"'
            ],
            0
        );

        $hexKey = null;

        switch ($keyChoice) {
            case '输入自定义的"长度为64的16进制的密钥"':
                $hexKey = $this->askForHexKey();
                if (!$hexKey) return;
                break;
            case '生成新的随机"长度为64的16进制的密钥"':
                $hexKey = $this->generateHexKey();
                $this->info('已生成并设置新的随机"长度为64的16进制的密钥": ' . $hexKey);
                break;
        }

        $this->newLine();
        $this->info('这个工具允许您输入多行文本进行加密。');
        $this->info('您可以输入任意多行文本，包括空行。');
        $this->info('当您完成输入后，需要一个特殊的标记来表示输入结束。');
        $this->newLine();

        $endMarker = $this->ask('请设置您的输入结束标记（直接按回车将使用默认值"EOF"）');
        $endMarker = $endMarker ?: 'EOF';

        $this->newLine();
        $this->info('现在您可以开始输入要加密的文本：');
        $this->info("（当输入完成时，请单独输入一行 \"{$endMarker}\" 来结束输入）");
        $this->newLine();

        $lines = [];
        while (true) {
            $line = $this->ask('');
            if ($line === $endMarker) {
                if (empty($lines)) {
                    if (!$this->confirm('您还没有输入任何内容，确定要结束输入吗？')) {
                        continue;
                    }
                } else {
                    if (!$this->confirm('确定要结束输入吗？')) {
                        continue;
                    }
                }
                break;
            }
            $lines[] = $line;
        }

        if (empty($lines)) {
            $this->error('没有输入任何内容，操作取消');
            return;
        }

        $str = implode("\n", $lines);

        $this->newLine();
        $this->info('=== 您输入的原文 ===');
        $this->info($str);
        $this->newLine();

        $encrypted = $this->encrypt_with_hex_key($hexKey, $str);

        // 输出加密后的字符串
        $this->info('=== 加密结果 start ===');
        $this->info('加密后的字符串(密文): ' . $encrypted);
        $this->info('=== 加密结果  end  ===');
        $this->newLine();
        $this->warn('请记住您的自定义16进制密钥, 解密时需要使用相同的密钥: ' . $hexKey);
        $this->newLine();
        $this->info('加密完成！');
        $this->newLine();
    }
}
