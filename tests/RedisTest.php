<?php

namespace rockunit;

use rock\cache\CacheInterface;
use rock\cache\Redis;

/**
 * @group cache
 * @group redis
 */
class RedisTest extends CommonCache
{
    public function setUp()
    {
        if (!class_exists('\Redis')) {
            $this->markTestSkipped(
                'The \Redis is not available.'
            );
        }

        (new Redis())->flush();
    }

    public function init($serialize)
    {
        if (!class_exists('\Redis')) {
            $this->markTestSkipped(
                'The \Redis is not available.'
            );
        }
        return new Redis(['serializer' => $serialize]);
    }

    /**
     * @dataProvider providerCache
     */
    public function testGetStorage(CacheInterface $cache)
    {
        $this->assertTrue($cache->getStorage() instanceof \Redis);
    }

    /**
     * @dataProvider providerCache
     * @expectedException \rock\cache\CacheException
     */
    public function testGetAll(CacheInterface $cache)
    {
        $cache->getAll();
    }
}
 