<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Translation;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Translation\LangData;
use Xpressengine\Translation\TransCachedDatabase;

class TransCachedDatabaseTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testSetCacheKey()
    {
        $cache = $this->getCache();
        $cache->shouldReceive('setCacheKey')->andReturn(null);

        $conn = $this->getConn();

        $cachedDb = new TransCachedDatabase($cache, $conn);
        $cachedDb->setCacheKey('cachKey');
    }

    public function testPutLangData()
    {
        $cache = $this->getCache();
        $cache->shouldReceive('get')->andReturn(null);
        $cache->shouldReceive('set');
        $cache->shouldReceive('flush');

        $conn = $this->getConn();
        $conn->shouldReceive('first')->andReturn((object)['value' => 'message']);
        $conn->shouldReceive('count')->andReturnValues([0, 1]);

        $langData = new LangData();
        $langData->setData(['foo', 'foo', 'foo']);
        $cachedDb = new TransCachedDatabase($cache, $conn);
        $cachedDb->putLangData('ns', $langData);
        $cachedDb->putLangData('ns', $langData);
        $this->assertSame('message', $cachedDb->getLine('ns', 'item', 'locale'));
    }

    public function testGetLine()
    {
        $cache = $this->getCache();
        $cache->shouldReceive('get')->andReturn(null);
        $cache->shouldReceive('set');

        $conn = $this->getConn();
        $conn->shouldReceive('first')->andReturn((object)['value' => 'message']);

        $cachedDb = new TransCachedDatabase($cache, $conn);
        $cachedDb->putLangData('ns', new LangData());
        $this->assertSame('message', $cachedDb->getLine('ns', 'locale', 'item'));
    }

    protected function getCache()
    {
        return m::mock('Xpressengine\Translation\TransCache');
    }

    protected function getConn()
    {
        $conn = m::mock(\Xpressengine\Database\VirtualConnectionInterface::class);
        $conn->shouldReceive('where')->andReturn(m::self());
        $conn->shouldReceive('table')->andReturn(m::self());
        $conn->shouldReceive('insert')->andReturn(m::self());
        $conn->shouldReceive('update')->andReturn(m::self());

        return $conn;
    }
}
