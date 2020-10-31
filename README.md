# Redis cache fallback package for Laravel 8 / Laravel 8的Redis缓存后备软件包 / Redisが落ちてもLaravelを落さない為のパッケージ(Laravel 8対応)

## Purpose of this package / 该包装的目的 / このパッケージの目的
(English) This package is for falling back to array if redis server is not available for cache of laravel.

Currently array is specified as falling back because it can store tagged data.

But please be careful that it is alsmost same with not using cache in terms of performance.

This is created referencing to https://github.com/24i/laravel-redis-fallback for 

- making falling back package work with Laravel 8
- making falling back package work with tagging function

(中文) 如果redis服务器不可用于laravel的缓存，则此软件包用于回退到阵列。

当前将数组指定为回退，因为它可以存储标记的数据。

但是请注意，就性能而言，不使用缓存几乎是相同的。

参照 https://github.com/24i/laravel-redis-fallback 创建

- 使用Laravel 8使回退包工作
- 使用标签功能使后退包装起作用

(日本語) このパッケージはRedistが落ちた時に、Laravelがそれでも例外エラーを出さずに動かし続けさせる為のパッケージです。
色々用途に合うパッケージを探していましたが

- Laravel 8に対応してない
- タグを使ってる場合に対応していない

為、
https://github.com/24i/laravel-redis-fallback
を開始にあたってのコードとして参照して、そこからは自分で作る事にしました。

Redisが使えない場合、arrayがcacheの代わりの保存先として使われます。
結果として

- パフォーマンスの向上はほぼ期待できませんが、Redisが落ちてもシステムは稼働し続ける
- ARedis復旧後の後始末をしなくても済む

という所に特徴があります

## How to install & set up / インストール・設定方法
```
composer require hikarine3/laravel-redis-fallback;
```

(English) Replace the default cache service provider in config/app.php

(中文) 替换config/app.php中的默认缓存服务提供程序

(日本語) app/config.php の以下の部分を書き換えて下さい

```php
'providers' => array(
	...
	//'Illuminate\Cache\CacheServiceProvider::class',
	...
	\Hikarine3\LaravelRedisFallback\LaravelRedisFallbackServiceProvider::class
	...
)
```

## Test

(English) You should test whether the system can run without exception even if redis service stopped.

(中文) 即使redis服务停止，也应该测试系统是否可以正常运行。

(日本語) Redisを落としても、システムがきちんと稼働することを確認の上で、使って下さい。

# License / ライセンス / 执照

MIT

# Author / 作者

## Name / 名前 / 全名
Hajime Kurita

## Twitter
- EN: https://twitter.com/hajimekurita
- JP: https://twitter.com/hikarine3

## Weibo
- CN: https://www.weibo.com/hajimekurita

## Corporation page / 会社ページ / 公司页面
- EN: https://1stclass.co.jp/en/
- CN: https://1stclass.co.jp/zh/
- JP: https://1stclass.co.jp/

## Blog
- EN: https://en.sakuhindb.com/pe/Administrator/
- JP: https://sakuhindb.com/pj/6_B4C9CDFDBFCDA4B5A4F3/

## Techincoal web services / 提供してる技術関連Webサービス / Techincoal Web服务
### VPS & Infra comparison / VPS比較 / VPS比较
- EN: https://vpsranking.com/en/
- CN: https://vpsranking.com/zh/
- JP: https://vpshikaku.com/

### Programming Language Comparison / プログラミング言語比較 / 编程语言比较
- EN: https://programminglang.com/en/
- CN: https://programminglang.com/zh/
- JP: https://programminglang.com/ja/

### OSS
- Docker: https://hub.docker.com/u/1stclass/
- Github: https://github.com/hikarine3
- NPM: https://www.npmjs.com/~hikarine3
- Perl: http://search.cpan.org/~hikarine/
- PHP: https://packagist.org/packages/hikarine3/
- Python: https://pypi.org/user/hikarine3/
