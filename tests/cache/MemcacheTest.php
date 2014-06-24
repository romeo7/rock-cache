<?php
namespace rockunit\cache;

use rock\cache\CacheInterface;
use rock\cache\Exception;
use rock\cache\Memcache;
use rockunit\TestCase;

class MemcacheTest extends TestCase
{
    public static function flush()
    {
        (new Memcache(['enabled' => true]))->flush();
    }

    public function init($serialize)
    {
        $cache = new Memcache(['enabled' => true, 'serializer' => $serialize]);
        return $cache;
    }


    /**
     * @group ignore-cache
     * @dataProvider providerCache
     * @expectedException Exception
     */
    public function testGetAllKeys(CacheInterface $cache)
    {
        parent::testGetAllKeys($cache);
    }
}
 