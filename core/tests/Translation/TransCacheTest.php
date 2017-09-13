<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Translation;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Translation\TransCache;

class TransCacheTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @expectedException \Exception
     */
    public function testExceptionWhenCacheKeyIsNotSet()
    {
        $transCache = new TransCache($this->getCache());
        $transCache->get('ns', 'xe', 'en');
    }

    public function testGetNull()
    {
        $cache = $this->getCache();
        $cache->shouldReceive('forever');
        $cache->shouldReceive('get')->with('cacheKey')->andReturn(json_encode([]));

        $transCache = new TransCache($cache);
        $transCache->setCacheKey('cacheKey');
        $this->assertNull($transCache->get('ns', 'xe', 'en'));
    }

    public function testCacheMissed()
    {
        $cache = $this->getCache();
        $cache->shouldReceive('forever');
        $cache->shouldReceive('get')->andReturn(null);

        $transCache = new TransCache($cache);
        $transCache->setCacheKey('cacheKey');
        $this->assertNull($transCache->get('ns', 'xe', 'en'));
    }

    public function testSetData()
    {
        $cache = $this->getCache();
        $cache->shouldReceive('forever');
        $cache->shouldReceive('get')->andReturn(json_encode([]));

        $transCache = new TransCache($cache);
        $transCache->setCacheKey('cacheKey');

        $this->assertNull($transCache->get('ns', 'me', 'en'));
        $transCache->set('ns', 'me', 'en', 'human');
        $this->assertSame('human', $transCache->get('ns', 'me', 'en'));
    }

    public function testGetCachedData()
    {
        $cache = $this->getCache();
        $cache->shouldReceive('forever');
        $cache->shouldReceive('get')->andReturn(json_encode(['ns' => ['xe' => ['en' => 'cms']]]));

        $transCache = new TransCache($cache);
        $transCache->setCacheKey('cacheKey');
        $this->assertSame('cms', $transCache->get('ns', 'xe', 'en'));
    }

    public function testFlush()
    {
        $cache = $this->getCache();
        $cache->shouldReceive('flush');
        $cache->shouldReceive('getStore')->andReturn(m::self());

        $transCache = new TransCache($cache);
        $transCache->flush();
    }

    protected function getCache()
    {
        return m::mock('Illuminate\Cache\Repository');
    }
}
