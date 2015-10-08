<?php
namespace rock\cache;

use rock\helpers\SerializeInterface;

/**
 * @property int $hashKey hashing key
 * @property int $hashTag hashing tag
 * @property int $serializer select serializer
 */
interface CacheInterface extends SerializeInterface
{
    const HASH_MD5 = 1;
    const HASH_SHA = 2;

    const LOCK_PREFIX = 'lock_';
    const TAG_PREFIX = 'tag_';

    /**
     * Returns current cache-storage.
     *
     * @throws CacheException
     * @return \Memcached|\Memcache|\Redis|\CouchbaseBucket
     */
    public function getStorage();

    /**
     * Returns prepare key of cache.
     *
     * @param string $key key of cache
     * @return bool|string
     */
    public function prepareKey($key);

    /**
     * Adds prefix to key.
     *
     * @param string $prefix
     */
    public function addPrefix($prefix);

    /**
     * Returns cache by key.
     *
     * @param string $key key of cache
     * @return mixed|bool
     */
    public function get($key);

    /**
     * Returns multiple cache by keys.
     *
     * @param array $keys keys of cache
     * @return array
     */
    public function getMulti(array $keys);

    /**
     * Set cache.
     *
     * @param string $key key of cache
     * @param mixed $value content of cache
     * @param int $expire time to live (sec)
     * @param array $tags tags
     * @return bool
     */
    public function set($key, $value = null, $expire = 0, array $tags = []);

    /**
     * Set multiple cache.
     *
     * ```php
     * $cache = new Memcached;
     * $cache->setMulti(['key_1' => 'text_1', 'key_2' => 'text_2'], 0, ['tag_1', 'tag_2'])
     * ```
     *
     * @param array $values
     * @param int $expire time to live (sec)
     * @param array $tags names tags
     */
    public function setMulti($values, $expire = 0, array $tags = []);

    /**
     * Adding cache (return false, if already exists on the server).
     *
     * @param string $key key of cache
     * @param mixed $value content of cache
     * @param int $expire time to live (sec)
     * @param array $tags tags
     * @return bool
     */
    public function add($key, $value = null, $expire = 0, array $tags = []);

    /**
     * Checks existence cache by key.
     *
     * @param string $key key of cache
     * @return bool
     */
    public function exists($key);

    /**
     * Changes expire for cache (TTL).
     *
     * @param string $key key of cache
     * @param int $expire time to live (sec)
     * @return bool
     */
    public function touch($key, $expire = 0);

    /**
     * Changes expire for multiple cache.
     *
     * @param array $keys keys of cache
     * @param int $expire time to live (sec)
     * @return bool
     */
    public function touchMulti(array $keys, $expire = 0);

    /**
     * Increment.
     *
     * @param string $key key of cache
     * @param int $offset
     * @param int $expire time to live (sec)
     * @param bool $create should the value be created if it doesn't exist
     * @return bool|int
     */
    public function increment($key, $offset = 1, $expire = 0, $create = true);

    /**
     * Decrement.
     *
     * @param string $key key of cache.
     * @param int $offset
     * @param int $expire time to live (sec)
     * @param bool $create should the value be created if it doesn't exist
     * @return int|bool
     */
    public function decrement($key, $offset = 1, $expire = 0, $create = true);

    /**
     * Removes cache.
     *
     * @param string $key key of cache
     * @return bool
     */
    public function remove($key);

    /**
     * Removes multiple keys.
     *
     * @param array $keys keys of cache
     */
    public function removeMulti(array $keys);

    /**
     * Returns tag.
     *
     * @param string $tag name of tag
     * @return mixed
     */
    public function getTag($tag);

    /**
     * Returns tags.
     *
     * @param array $tags names of tags
     * @return array
     */
    public function getMultiTags(array $tags);

    /**
     * Checks existence tag.
     *
     * @param string $tag name of tag
     * @return bool
     */
    public function existsTag($tag);

    /**
     * Removes tag.
     *
     * @param string $tag name of tag
     * @return bool
     */
    public function removeTag($tag);

    /**
     * Removes multiple tags.
     *
     * @param array $tags names of tags
     */
    public function removeMultiTags(array $tags);

    /**
     * Returns all keys of cache.
     * @return array
     */
    public function getAllKeys();

    /**
     * Returns all cache.
     * @return array
     * @throws CacheException
     */
    public function getAll();

    /**
     * Set lock.
     *
     * > Dog-pile" ("cache miss storm") and "race condition" effects
     *
     * @param string $key key of cache
     * @param int $iteration max iteration
     * @return bool
     */
    public function lock($key, $iteration = 15);

    /**
     * Delete lock.
     *
     * @param string $key key of cache
     * @return bool
     */
    public function unlock($key);

    /**
     * Removes all cache.
     * @return bool
     */
    public function flush();

    /**
     * Returns status server of cache.
     * @throws CacheException
     * @return mixed
     */
    public function status();
}