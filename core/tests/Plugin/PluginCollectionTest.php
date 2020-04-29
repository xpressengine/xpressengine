<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

    public function testInitializeWithRefresh()
    {
        $configs = \Mockery::mock('Xpressengine\Config\ConfigManager');
        $configs->shouldReceive('getVal')->andReturn([]);
        PluginCollection::setConfig($configs);

        $collection = new PluginCollection($this->getPluginInfos());

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

        $data = $collection->fetch(['keyword' => 'xe']);
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
