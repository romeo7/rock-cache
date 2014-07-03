<?php

namespace rockunit;


use rock\cache\helpers\Serialize;

class SerializeTest extends \PHPUnit_Framework_TestCase
{
    public function testSerialize()
    {
        // PHP serializer
        $this->assertSame(Serialize::serialize(['foo', 'bar']), serialize(['foo', 'bar']));

        // Json serialozer
        $this->assertSame(Serialize::serialize(['foo', 'bar'], Serialize::SERIALIZE_JSON), json_encode(['foo', 'bar']));
    }

    public function testIsTrue()
    {
        $this->assertTrue(Serialize::is(serialize(['foo', 'bar'])));
    }

    public function testIsFalse()
    {
        $this->assertFalse(Serialize::is('foo'));
    }

    public function testUnserialize()
    {
        // PHP
        $this->assertSame(Serialize::unserialize(serialize(['foo', 'bar'])), ['foo', 'bar']);

        // Json
        $this->assertSame(Serialize::unserialize(json_encode(['foo', 'bar'])), ['foo', 'bar']);

        // skip
        $this->assertSame(Serialize::unserialize(['foo', 'bar'], false), ['foo', 'bar']);

        // Exception
        $this->setExpectedException('rock\cache\Exception');
        Serialize::unserialize(['foo', 'bar']);
    }
}
 