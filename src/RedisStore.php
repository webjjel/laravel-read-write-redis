<?php

namespace Webjjel\ReadWriteRedis;

use Illuminate\Cache\RedisStore as IlluminateRedisStore;
use Illuminate\Contracts\Redis\Factory as Redis;

class RedisStore extends IlluminateRedisStore
{
    const WRITE_MODE = 'write';
    const READ_MODE = 'read';

    /**
     * @var string
     */
    protected $mode = self::WRITE_MODE;

    /**
     * @var array
     */
    protected $connections = [];

    /**
     * Create a new Redis store.
     *
     * @param  \Illuminate\Contracts\Redis\Factory  $redis
     * @param  string  $prefix
     * @param  array  $connections
     * @return void
     */
    public function __construct(Redis $redis, $prefix = '', $connections = [])
    {
        $this->connections = $connections;
        parent::__construct($redis, $prefix, $connections[$this->mode]);
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|array  $key
     * @return mixed
     */
    public function get($key)
    {
        $this->setReadMode();
        return parent::get($key);
    }

    /**
     * Retrieve multiple items from the cache by key.
     *
     * Items not found in the cache will have a null value.
     *
     * @param  array  $keys
     * @return array
     */
    public function many(array $keys)
    {
        $this->setReadMode();
        return parent::many($keys);
    }

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  int  $seconds
     * @return bool
     */
    public function put($key, $value, $seconds)
    {
        $this->setWriteMode();
        return parent::put($key, $value, $seconds);
    }

    /**
     * Store multiple items in the cache for a given number of minutes.
     *
     * @param  array  $values
     * @param  int  $seconds
     * @return bool
     */
    public function putMany(array $values, $seconds)
    {
        $this->setWriteMode();
        return parent::putMany($values, $seconds);
    }

    /**
     * Store an item in the cache if the key doesn't exist.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  int  $seconds
     * @return bool
     */
    public function add($key, $value, $seconds)
    {
        $this->setWriteMode();
        return parent::add($key, $value, $seconds);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return int
     */
    public function increment($key, $value = 1)
    {
        $this->setWriteMode();
        return parent::increment($key, $value);
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return int
     */
    public function decrement($key, $value = 1)
    {
        $this->setWriteMode();
        return parent::decrement($key, $value);
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return bool
     */
    public function forever($key, $value)
    {
        $this->setWriteMode();
        return parent::forever($key, $value);
    }

    /**
     * Get a lock instance.
     *
     * @param  string  $name
     * @param  int  $seconds
     * @param  string|null $owner
     * @return \Illuminate\Contracts\Cache\Lock
     */
    public function lock($name, $seconds = 0, $owner = null)
    {
        $this->setWriteMode();
        return parent::lock($name, $seconds, $owner);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function forget($key)
    {
        $this->setWriteMode();
        return parent::forget($key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush()
    {
        $this->setWriteMode();
        return parent::flush();
    }

    /**
     * Begin executing a new tags operation.
     *
     * @param  array|mixed  $names
     * @return \Illuminate\Cache\RedisTaggedCache
     */
    public function tags($names)
    {
        $this->setWriteMode();
        return parent::tags($names);
    }

    /**
     * Get the Redis connection instance.
     *
     * @return \Predis\ClientInterface
     */
    public function connection()
    {
        return $this->redis->connection($this->connections[$this->mode]);
    }

    protected function setWriteMode()
    {
        $this->mode = self::WRITE_MODE;
    }

    protected function setReadMode()
    {
        $this->mode = self::READ_MODE;
    }
}
