<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Support;

use Xpressengine\Support\Singleton;

class SingletonTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructAllSameInstance()
    {
        $sample1 = SampleSingleton::instance();
        $sample1->set('foo', 'bar');

        $sample2 = SampleSingleton::instance();
        $sample2->set('baz', 'qux');

        $sample3 = SampleSingleton::instance();
        $this->assertEquals('bar', $sample3->get('foo'));
        $this->assertEquals([
            'foo' => 'bar',
            'baz' => 'qux',
        ], $sample3->getAttributes());
    }

    public function testConstructAllSameInstance2()
    {
        $sample1 = SampleSingleton2::instance();
        $sample1->set('aaa', 'bbb');

        $sample2 = SampleSingleton2::instance();
        $sample2->set('ccc', 'ddd');

        $sample3 = SampleSingleton2::instance();
        $this->assertEquals('bbb', $sample3->get('aaa'));
        $this->assertEquals([
            'aaa' => 'bbb',
            'ccc' => 'ddd',
        ], $sample3->getAttributes());
    }

    public function testConstructAllSameInstanceReCall()
    {
        $sample1 = SampleSingleton::instance();
        $sample1->set('foo', 'bar');

        $sample2 = SampleSingleton::instance();
        $sample2->set('baz', 'qux');

        $sample3 = SampleSingleton::instance();
        $this->assertEquals('bar', $sample3->get('foo'));
        $this->assertEquals([
            'foo' => 'bar',
            'baz' => 'qux',
        ], $sample3->getAttributes());

        $sample4 = SampleSingleton2::instance();
        $sample4->set('aaa', 'bbb');

        $sample5 = SampleSingleton2::instance();
        $sample5->set('ccc', 'ddd');

        $sample6 = SampleSingleton2::instance();
        $this->assertEquals('bbb', $sample6->get('aaa'));
        $this->assertEquals([
            'aaa' => 'bbb',
            'ccc' => 'ddd',
        ], $sample6->getAttributes());

        $sample7 = SampleSingleton::instance();
        $this->assertEquals('bar', $sample7->get('foo'));
        $this->assertEquals([
            'foo' => 'bar',
            'baz' => 'qux',
        ], $sample7->getAttributes());
    }
}

class SampleSingleton extends Singleton
{
    protected $attributes = [];

    public function get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    public function set($key, $val)
    {
        $this->attributes[$key] = $val;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}

class SampleSingleton2 extends Singleton
{
    protected $attributes = [];

    public function get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    public function set($key, $val)
    {
        $this->attributes[$key] = $val;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
