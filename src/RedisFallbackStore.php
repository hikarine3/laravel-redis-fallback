<?php

namespace Hikarine3\LaravelRedisFallback;

use Illuminate\Cache\RedisStore;
use Illuminate\Contracts\Redis\Factory as Redis;
use Illuminate\Support\Facades\Cache;
use Predis\ClientException;

class RedisFallbackStore extends RedisStore
{
    /**
     * @var \Closure|null
     */
    protected $onFallback;

    /**
     * RedisFallbackStore constructor.
     * @param Redis $redis
     * @param string $prefix
     * @param string $connection
     * @param \Closure|null $onFallback
     */
    public function __construct(Redis $redis, $prefix = '', $connection = 'default', \Closure $onFallback = null)
    {
        parent::__construct($redis, $prefix, $connection);

        $this->onFallback = $onFallback;
    }

    /**
     * @param array|string $key
     * @return mixed
     * @throws ClientException
     */
    public function get($key)
    {
        try {
            return parent::get($key);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'get', $key);
        }
    }

    /**
     * @param array $keys
     * @return array|mixed
     * @throws ClientException
     */
    public function many(array $keys)
    {
        try {
            return parent::many($keys);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'many', $keys);
        }

    }

    /**
     * @param string $key
     * @param mixed $value
     * @param float|int $minutes
     * @return mixed|void
     * @throws ClientException
     */
    public function put($key, $value, $minutes)
    {
        try {
            parent::put($key, $value, $minutes);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'put', $key, $value, $minutes);
        }
    }

    /**
     * @param array $values
     * @param float|int $minutes
     * @return mixed|void
     * @throws ClientException
     */
    public function putMany(array $values, $minutes)
    {
        try {
            parent::putMany($values, $minutes);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'putMany', $values, $minutes);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param float|int $minutes
     * @return bool|mixed
     * @throws ClientException
     */
    public function add($key, $value, $minutes)
    {
        try {
            return parent::add($key, $value, $minutes);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'add', $key, $value, $minutes);
        }
    }

    /**
     * @param string $key
     * @param int $value
     * @return int|mixed
     * @throws ClientException
     */
    public function increment($key, $value = 1)
    {
        try {
            return parent::increment($key, $value);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'increment', $key, $value);
        }
    }

    /**
     * @param string $key
     * @param int $value
     * @return int|mixed
     * @throws ClientException
     */
    public function decrement($key, $value = 1)
    {
        try {
            return parent::decrement($key, $value);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'decrement', $key, $value);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed|void
     * @throws ClientException
     */
    public function forever($key, $value)
    {
        try {
            parent::forever($key, $value);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'forever', $key, $value);
        }
    }

    /**
     * @param string $name
     * @param int $seconds
     * @param null $owner
     * @return \Illuminate\Contracts\Cache\Lock|mixed
     * @throws ClientException
     */
    public function lock($name, $seconds = 0, $owner = null)
    {
        try {
            return parent::lock($name, $seconds, $owner);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'lock', $name, $seconds);
        }
    }

    /**
     * @param string $key
     * @return bool|mixed
     * @throws ClientException
     */
    public function forget($key)
    {
        try {
            return parent::forget($key);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'forget', $key);
        }
    }

    /**
     * @return bool|mixed
     * @throws ClientException
     */
    public function flush()
    {
        try {
            return parent::flush();
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'flush');
        }
    }

    /**
     * @param array|mixed $names
     * @return \Illuminate\Cache\RedisTaggedCache|mixed
     * @throws ClientException
     */
    public function tags($names)
    {
        try {
            return parent::tags($names);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'tags', $names);
        }
    }

    /**
     * @return mixed|\Predis\ClientInterface
     * @throws ClientException
     */
    public function connection()
    {
        try {
            return parent::connection();
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'connection');
        }
    }

    /**
     * @param string $connection
     * @return mixed|void
     * @throws ClientException
     */
    public function setConnection($connection)
    {
        try {
            parent::setConnection($connection);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'setConnection', $connection);
        }
    }

    /**
     * @return Redis|mixed
     * @throws ClientException
     */
    public function getRedis()
    {
        try {
            return parent::getRedis();
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'getRedis');
        }
    }

    /**
     * @return mixed|string
     * @throws ClientException
     */
    public function getPrefix()
    {
        try {
            return parent::getPrefix();
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'getPrefix');
        }
    }

    /**
     * @param string $prefix
     * @return mixed|void
     * @throws ClientException
     */
    public function setPrefix($prefix)
    {
        try {
            parent::setPrefix($prefix);
        } catch (ClientException $e) {
            return $this->handleClientException($e, 'setPrefix', $prefix);
        }
    }

    /**
     * @param ClientException $e
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws ClientException
     */
    private function handleClientException(ClientException $e, string $method, ...$arguments)
    {
        if ($e->getMessage() === 'No connections available in the pool') {
            if ($this->onFallback) {
                $this->onFallback->call($this);
            }

            return Cache::store('array')->$method(...$arguments);
        }

        throw $e;
    }
}