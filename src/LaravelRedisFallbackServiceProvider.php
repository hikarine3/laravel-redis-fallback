<?php

namespace Hikarine3\LaravelRedisFallback;

use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Cache\MemcachedConnector;
use Illuminate\Foundation\AliasLoader;

/**
 * Redis fallback service provider
 *
 * @package Hikarine3
 * @subpackage LaravelRedisFallback
 */
class LaravelRedisFallbackServiceProvider extends CacheServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('LaravelRedisFallback', LaravelRedisFallbackFacade::class);
        });
    }

    /**
     * Register
     *
     * @return mixed
     */
    public function register()
    {
        $this->app->singleton('cache', function ($app) {
            return new LaravelRedisFallback($app);
        });

        $this->app->singleton('cache.store', function ($app) {
            return $app['cache']->driver();
        });

        $this->app->singleton('memcached.connector', function () {
            return new MemcachedConnector;
        });
    }
}
