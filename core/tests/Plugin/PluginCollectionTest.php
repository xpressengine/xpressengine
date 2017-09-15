<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin;

use Xpressengine\Plugin\PluginCollection;
use Xpressengine\Plugin\PluginHandler as Plugin;

class PluginCollectionTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $scanner = \Mockery::mock(
            '\Xpressengine\Plugin\PluginScanner',
            [
                'scanDirectory' => $this->getPluginInfos()
            ]
        );

        $cache = \Mockery::mock('Xpressengine\Plugin\Cache\PluginCache');
        $cache->shouldReceive('hasCachedPlugins')->andReturnNull();
        $cache->shouldReceive('setPluginsToCache')->andReturnNull();

        $collection = new PluginCollection($scanner, $cache, PluginEntityStub::class, []);

        $this->assertInstanceOf('\Xpressengine\Plugin\PluginCollection', $collection);

        return $collection;
    }

    public function testInitializeWithRefresh()
    {
        $scanner = \Mockery::mock(
            '\Xpressengine\Plugin\PluginScanner',
            [
                'scanDirectory' => $this->getPluginInfos()
            ]
        );

        $cache = \Mockery::mock('Xpressengine\Plugin\Cache\PluginCache');
        $cache->shouldReceive('hasCachedPlugins')->once()->andReturnNull();
        $cache->shouldReceive('hasCachedPlugins')->once()->andReturn(true);
        $cache->shouldReceive('getPluginsFromCache')->once()->andReturn($this->getPluginInfos());
        $cache->shouldReceive('setPluginsToCache')->once()->andReturnNull();

        $collection = new PluginCollection($scanner, $cache, PluginEntityStub::class, []);

        $collection->initialize(false);

        $this->assertCount(2, $this->getPropertyValue($collection, 'plugins'));

        return $collection;
    }

    /**
     * @depends testConstruct
     */
    public function testFetch(PluginCollection $collection)
    {
        $data = $collection->fetch(['component' => 'menu']);
        $this->assertCount(2, $data);

        $data = $collection->fetch(['status' => Plugin::STATUS_ACTIVATED]);
        $this->assertCount(2, $data);

        $data = $collection->fetch(['keyword' => 'sample2']);
        $this->assertCount(1, $data);

        $data = $collection->fetch(['keyword' => 'khongchi']);
        $this->assertCount(0, $data);

        $data = $collection->fetch(['keyword' => 'sample_author']);
        $this->assertCount(1, $data);
    }

    /**
     * @depends testConstruct
     */
    public function testHas(PluginCollection $collection)
    {
        $this->assertTrue($collection->has('plugin_sample'));
        $this->assertTrue($collection->has('plugin_sample2'));
        $this->assertFalse($collection->has('plugin_sample3'));
    }

    /**
     * @depends testConstruct
     */
    public function testGet(PluginCollection $collection)
    {
        $this->assertInstanceOf('\Xpressengine\Tests\Plugin\PluginEntityStub', $collection->get('plugin_sample'));
        $this->assertInstanceOf('\Xpressengine\Tests\Plugin\PluginEntityStub', $collection->get('plugin_sample2'));
        $this->assertNull($collection->get('plugin_sample3'));
    }


    /**
     * @depends testConstruct
     */
    public function testGets(PluginCollection $collection)
    {
        $this->assertCount(2, $collection->getList());
        $this->assertCount(1, $collection->getList('plugin_sample'));
        $this->assertCount(2, $collection->getList(['plugin_sample', 'plugin_sample2']));
        $this->assertCount(1, $collection->getList(['plugin_sample', 'plugin_sample3']));
    }

    /**
     * @depends testConstruct
     */
    public function testIterator(PluginCollection $collection)
    {
        $i = 0;
        foreach ($collection as $entity) {
            $this->assertInstanceOf('\Xpressengine\Tests\Plugin\PluginEntityStub', $entity);
            $i++;
        }

        $this->assertEquals(2, $i);
    }

    /**
     * @depends testConstruct
     */
    public function testCount(PluginCollection $collection)
    {
        $this->assertEquals(2, $collection->count());
    }

    protected function getPropertyValue($object, $property)
    {
        $refl     = new \ReflectionObject($object);
        $repoProp = $refl->getProperty($property);
        $repoProp->setAccessible(true);
        return $repoProp->getValue($object);
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
}

class PluginEntityStub
{
    protected $id;
    protected $path;
    protected $class;
    protected $metaData;

    public static function setCollection($collection)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->id.'_description';
    }

    public function getKeywords()
    {
        return [$this->id.'_keyword', $this->id.'_keyword2'];
    }

    public function getAuthors()
    {
        return $this->id.'_author';
    }

    public function getStatus()
    {
        return Plugin::STATUS_ACTIVATED;
    }

    public function getTitle()
    {
        return $this->id.'_title';
    }

    public function getComponentList($component)
    {
        return ['foo'];
    }

    public function __construct($id, $path, $class, $metaData = [])
    {
        $this->id       = $id;
        $this->path     = $path;
        $this->class    = $class;
        $this->metaData = $metaData;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'class' => $this->class,
            'status' => $this->getStatus(),
            'metaData' => $this->metaData
        ];
    }

    public function setMetaData($data)
    {
    }
}
