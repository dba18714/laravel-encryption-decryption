# Laravel 加密解密工具

一个基于 Laravel 的命令行加密解密工具，支持使用自定义16进制密钥进行加密和解密操作。

## 功能特点

- 支持使用自定义16进制密钥进行加密/解密
- 支持多行文本加密
- 支持从文件读取密文进行解密
- 使用 Laravel 的加密机制，确保数据安全性
- 使用 AES-256-CBC 加密算法
- 支持生成随机密钥

## 系统要求

- PHP >= 8.1
- Laravel >= 10.x
- OpenSSL PHP 扩展

## 安装

1. 克隆项目到本地：
```bash
git clone https://github.com/dba18714/laravel-encryption-decryption.git
```

2. 安装依赖：
```bash
composer install
```

## 使用方法

### 加密命令

```bash
php artisan app:encrypt
```

加密命令支持：
- 输入自定义的64位16进制密钥
- 自动生成随机密钥
- 支持多行文本输入
- 使用自定义结束标记

### 解密命令

```bash
php artisan app:decrypt
```

解密命令支持：
- 直接输入密文解密
- 从文件读取密文：
```bash
php artisan app:decrypt --file=path/to/your/encrypted.txt
```

## 注意事项

1. 密钥要求：
   - 必须是64个16进制字符（32字节）
   - 请安全保存您的密钥，密文解密时需要使用相同的密钥

2. 密文格式：
   - 加密后的密文为 base64 编码格式
   - 解密时请确保密文的完整性

3. 文件路径：
   - 支持绝对路径和相对路径
   - 相对路径基于项目根目录

## 示例

### 加密示例：
```bash
php artisan app:encrypt
# 选择输入自定义密钥或生成随机密钥
# 输入要加密的文本
# 使用 EOF 或自定义标记结束输入
```

### 解密示例：
```bash
# 直接输入密文解密
php artisan app:decrypt

# 从文件读取密文解密
php artisan app:decrypt --file=./encrypted.txt
```

## 安全建议

1. 请妥善保管加密密钥
2. 建议使用安全的方式传输密文和密钥
3. 在生产环境中请使用 HTTPS 传输加密数据

## 许可证

本项目基于 [MIT license](https://opensource.org/licenses/MIT) 开源。
