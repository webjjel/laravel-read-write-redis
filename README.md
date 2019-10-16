## Laravel Read/Write Redis
[![Packagist License](https://poser.pugx.org/webjjel/laravel-read-write-redis/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/webjjel/laravel-read-write-redis/version.png)](https://packagist.org/packages/webjjel/laravel-read-write-redis)
[![Total Downloads](https://poser.pugx.org/webjjel/laravel-read-write-redis/d/total.png)](https://packagist.org/packages/webjjel/laravel-read-write-redis)

The `webjjel/laravel-read-write-redis` package provides read/write connection for redis.

## Installation
PHP 7.1 and Laravel 5.8 or higher are required.
You can install the package via composer:
``` bash
composer require webjjel/laravel-read-write-redis
```

The package will automatically register itself.

## Usage
You have to set the read/write connection in `config/database.php`
``` php
'redis' => [
    'write' => [
        'host'     => env('REDIS_WRITE_HOST', '127.0.0.1'),
        'password' => env('REDIS_WRITE_PASSWORD', null),
        'port'     => env('REDIS_WRITE_PORT', 6379),
        'database' => 0,
    ],

    'read' => [
        'host'     => env('REDIS_READ_HOST', '127.0.0.1'),
        'password' => env('REDIS_READ_PASSWORD', null),
        'port'     => env('REDIS_READ_PORT', 6379),
        'database' => 0,
    ],
],
```

and then set the redis connection in `config/cache.php`
``` php
'stores' => [
    'redis-read-write' => [
        'driver' => 'redis-read-write',
        'connection' => [
            'write' => 'write',
            'read'  => 'read',
        ],
    ],
]
```

If you want to use read/write redis cache by default, You can change environment in `.env`
``` env
CACHE_DRIVER=redis-read-write
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
