<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Plugin\Cache;

function json_dec($string, $assoc = false, $depth = 512, $options = 0)
{
    return $string;
}

function json_enc($value, $options = 0, $depth = 512)
{
    return $value;
}

namespace Xpressengine\Tests\Plugin;

use Illuminate\Cache\Repository;
use Mockery;
use Xpressengine\Plugin\Cache\FilePluginCache;

class FilePluginCacheTest extends \PHPUnit\Framework\TestCase
{
    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(FilePluginCache::class, $this->getCache());
    }

    public function testGetPluginsFromCache()
    {
        $repo = $this->makeRepo();
        $repo->shouldReceive('get')->with('list')->once()->andReturn($this->getPluginInfos());
        $cache = $this->getCache($repo);

        $plugins = $cache->getPluginsFromCache();
        $this->assertEquals($plugins, $this->getPluginInfos());

        $plugins = $cache->getPluginsFromCache();
        $this->assertEquals($plugins, $this->getPluginInfos());
    }

    public function testSetPluginsToCache()
    {
        $repo = $this->makeRepo();
        $repo->shouldReceive('forever')->withAnyArgs()->once()->andReturnNull();
        $cache = $this->getCache($repo);

        $cache->setPluginsToCache($this->getPluginInfos());
    }

    public function testHasCachedPlugins()
    {
        $repo = $this->makeRepo();
        $repo->shouldReceive('has')->with('list')->once()->andReturn(true);
        $cache = $this->getCache($repo);

        $this->assertTrue($cache->hasCachedPlugins());
    }

    private function getPluginInfos()
    {

        $infos = [
            "plugin_sample" => [
                'class' => 'Xpressengine\Tests\Plugin\Sample\PluginSample',
                'path' => __DIR__.'/plugins/plugin_sample/plugin.php',
                'metaData' => []
            ],
            "plugin_sample2" => [
                'class' => 'Xpressengine\Tests\Plugin\Sample\PluginSample2',
                'path' => __DIR__.'/plugins/plugin_sample2/plugin.php',
                'metaData' => []
            ]
        ];
        return $infos;
    }

    protected function makeRepo()
    {
        return Mockery::mock('\Illuminate\Cache\Repository');
    }

    protected function getCache(Repository $repo = null, $cacheKey = 'list')
    {
        if($repo === null) {
            $repo = $this->makeRepo();
        }

        return new FilePluginCache($repo, $cacheKey);
    }
}
