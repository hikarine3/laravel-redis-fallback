<?php

namespace Hikarine3\LaravelRedisFallback;

use Illuminate\Support\Facades\Facade;

/**
 * Redis fallback facade
 *
 * @package Hikarine3
 * @subpackage LaravelRedisFallback
 *
 */
class LaravelRedisFallbackFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-redis-fallback';
    }
}
