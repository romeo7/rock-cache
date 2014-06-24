<?php

namespace rock\cache\versioning;

use rock\cache\CacheInterface;
use rock\cache\helpers\Date;

class Redis extends \rock\cache\Redis implements CacheInterface
{
    use VersioningTrait;

    /** @var  \Redis */
    protected static $storage;

    /**
     * @inheritdoc
     */
    public function getTag($tag)
    {
        return static::$storage->get(self::TAG_PREFIX . $tag);
    }

    /**
     * @inheritdoc
     */
    public function removeTag($tag)
    {
        if (!$this->hasTag($tag)) {
            return false;
        }

        return $this->provideLock(self::TAG_PREFIX . $tag, microtime(), 0);
    }

    protected function validTimestamp($key, array $tagsByValue = null)
    {
        if (empty($tagsByValue)) {
            return true;
        }
        foreach ($tagsByValue as $tag => $timestamp) {
            if ((!$tagTimestamp = static::$storage->get($tag)) ||
                Date::microtime($tagTimestamp) > Date::microtime($timestamp)
            ) {
                static::$storage->delete($key);

                return false;
            }
        }

        return true;
    }
}