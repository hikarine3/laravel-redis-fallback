<?php

namespace Hikarine3\LaravelRedisFallback;

use Exception;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\RedisStore;
use Illuminate\Support\Arr;

/**
 * Redis fallback
 *
 * @package Hikarine3
 * @subpackage LaravelRedisFallback
 *
 */
class LaravelRedisFallback extends CacheManager
{

    /**
     * Create an instance of the Redis cache driver.
     *
     * @param  array $config
     *
     * @return \Illuminate\Cache\RedisStore|\Illuminate\Cache\ArrayStore
     */
    protected function createRedisDriver(array $config)
    {
        $redis = $this->app['redis'];

        $connection = Arr::get($config, 'connection', 'default') ?: 'default';

        $store = new RedisStore($redis, $this->getPrefix($config), $connection);

        try {
            $store->getRedis()->ping();

            return $this->repository($store);
        } catch (Exception $e) {
            event('redis.unavailable', null);
            // for supporting tag
            return parent::createArrayDriver(\Config::get('cache.stores.array'));
        }
    }
}
