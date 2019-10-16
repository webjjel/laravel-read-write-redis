<?php

namespace Webjjel\ReadWriteRedis;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class ReadWriteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Cache::extend('redis_read_write', function ($app, $config) {
            $connection = $config['connection'] ?? ['write' => 'write', 'read'  => 'read'];
            $prefix     = $config['prefix'] ?? $app['config']['cache.prefix'];

            return Cache::repository(new RedisStore($app['redis'], $prefix, $connection));
        });
    }
}