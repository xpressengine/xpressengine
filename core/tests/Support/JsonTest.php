<?php
namespace Xpressengine\Tests\Support;

use Xpressengine\Support\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function testEncodeReturnsString()
    {
        $array = ['foo' => 'bar', 'baz' => 1];
        $encodeString = Json::encode($array);

        $this->assertEquals('{"foo":"bar","baz":1}', $encodeString);
    }

    public function testEncodeThrownExceptionIfError()
    {
        try {
            $text = "\xB1\x31";
            $encodeString = Json::encode($text);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Support\JsonException', $e);
        }
    }

    public function testDecodeReturnsString()
    {
        $string = '{"foo":"bar","baz":1}';
        $decodeObject = Json::decode($string);

        $this->assertEquals((object)[
            'foo' => 'bar',
            'baz' => 1
        ], $decodeObject);
    }

    public function testDecodeThrownExceptionIfError()
    {
        try {
            $string = "{'foo':'bar','baz':1}";
            $decodeObject = Json::decode($string);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Support\JsonException', $e);
        }
    }
}
