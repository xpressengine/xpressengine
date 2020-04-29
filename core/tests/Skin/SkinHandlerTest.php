<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Skin;

use Mockery;
use Xpressengine\Register\Container;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Skin\SkinInstanceStore;

class SkinHandlerTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var SkinHandler
     */
    protected $handler;

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testGet()
    {
        $id = 'module/pluginA@board/skin/pluginA@blue';
        $this->assertEquals($id, $this->handler->get($id)->getId());
    }

    public function testGetList()
    {
        $skins = $this->handler->getList('module/pluginA@board');
        $this->assertCount(2, $skins);
        $skin = array_shift($skins);
        $this->assertEquals('module/pluginA@board/skin/pluginA@blue', $skin->getId());
    }

    public function testGetListOfSettingsSkin()
    {
        $skins = $this->handler->getList('module/pluginA@board', true);
        $this->assertEmpty($skins);
    }

    public function testGetListSupportingMobile()
    {
        $target = 'module/pluginA@real';
        $skins = $this->handler->getListSupportingMobile($target, true);

        $this->assertCount(1, $skins);
        $this->assertEquals('module/pluginA@real/settingsSkin/test', reset($skins)->getId());
    }

    public function testGetListSupportingDesktop()
    {
        $target = 'module/pluginA@real';
        $skins = $this->handler->getListSupportingDesktop($target, true);

        $this->assertCount(1, $skins);
        $this->assertEquals(TestSkin::class, reset($skins)->getClass());
    }

    public function testSetDefaultSkin()
    {
        $skinId = 'module/a/skin/default';
        $this->handler->setDefaultSkin('module/a', $skinId);
        $defaults = $this->getPropertyValue($this->handler, 'defaultSkins');
        $this->assertCount(1, $defaults);
        $this->assertContains($skinId, $defaults);
    }

    public function testSetDefaultSettingsSkin()
    {
        $skinId = 'module/a/skin/default';
        $this->handler->setDefaultSettingsSkin('module/a', $skinId);
        $defaults = $this->getPropertyValue($this->handler, 'defaultSettingsSkins');
        $this->assertCount(1, $defaults);
        $this->assertContains($skinId, $defaults);
    }

    public function testGetAssigndWhenStoredDataNotExists()
    {
        $key = 'module/pluginA@real';

        /** @var Mockery\MockInterface $store */
        $store = $this->getStore();
        $store->shouldReceive('getSelectedSkin')->withArgs([$key, 'desktop'])->andReturnNull();
        $store->shouldReceive('getConfigs')->withArgs([$key, 'module/pluginA@real/skin/test'])->andReturn(['config']);
        $this->handler->setStore($store);

        $this->handler->setDefaultSkin($key, 'module/pluginA@real/skin/test');
        $skinObj = $this->handler->getAssigned($key, null);
        $this->assertInstanceOf('\Xpressengine\Skin\SkinEntity', $skinObj);
        $this->assertEquals(['config'], $this->getPropertyValue($skinObj, 'config'));
    }

    public function testGetAssigndWhenStoredDataExists()
    {
        $key = 'module/pluginA@real';

        /** @var Mockery\MockInterface $store */
        $store = $this->getStore();
        $store->shouldReceive('getSelectedSkin')->withArgs([$key, 'desktop'])->andReturn(
            'module/pluginA@real/skin/test'
        );
        $store->shouldReceive('getConfigs')->withArgs([$key, 'module/pluginA@real/skin/test'])->andReturn(['config']);
        $this->handler->setStore($store);

        $this->handler->setDefaultSkin($key, 'module/pluginA@real/skin/test');
        $skinObj = $this->handler->getAssigned($key, null);
        $this->assertInstanceOf('\Xpressengine\Skin\SkinEntity', $skinObj);
        $this->assertEquals(['config'], $this->getPropertyValue($skinObj, 'config'));
    }

    /**
     * testGetAssigndWhenSkinNotExists
     *
     * @expectedException \Xpressengine\Skin\Exceptions\SkinNotFoundException
     */
    public function testGetAssigndWhenSkinNotExists()
    {
        $key = 'noskin';

        /** @var Mockery\MockInterface $store */
        $store = $this->getStore();
        $store->shouldReceive('getSelectedSkin')->withArgs([$key, 'desktop'])->andReturnNull();
        $store->shouldReceive('getConfigs')->withArgs([$key, 'noskin'])->andReturnNull();
        $this->handler->setStore($store);

        $skinObj = $this->handler->getAssigned($key, null);
    }

    public function testGetAssigndSettings()
    {
        $key = 'module/pluginA@real';

        $skinObj = $this->handler->getAssignedSettings($key);
        $this->assertInstanceOf('\Xpressengine\Skin\SkinEntity', $skinObj);
        $this->assertEmpty($this->getPropertyValue($skinObj, 'config'));
    }

    public function testAssign()
    {
        $key = 'module/pluginA@real';
        $instanceId = 'notice';
        $skin = [];

        $skin = Mockery::mock('\Xpressengine\Skin\SkinEntity');
        $skin->shouldReceive('getId')->andReturn('foo');
        $skin->shouldReceive('getConfig')->andReturn(['bar']);

        /** @var Mockery\MockInterface $store */
        $store = $this->getStore();
        $store->shouldReceive('setSelectedSkin')->withArgs(
            [$key.SkinHandler::INSTANCE_DELIMITER.$instanceId, 'desktop', 'foo']
        )->once()->andReturnNull();

        $this->handler->setStore($store);

        $this->handler->assign([$key, $instanceId], $skin);
    }


    public function testMergeKey()
    {
        $d = SkinHandler::INSTANCE_DELIMITER;
        $this->assertEquals("a{$d}b", $this->handler->mergeKey('a', 'b'));
        $this->assertEquals("a", $this->handler->mergeKey('a'));
        $this->assertEquals("a{$d}b", $this->handler->mergeKey(['a', 'b']));
        $this->assertEquals("a{$d}b{$d}c", $this->handler->mergeKey(['a', 'b'], 'c'));
        $this->assertEquals("a{$d}c", $this->handler->mergeKey(['a', null], 'c'));
    }

    protected function setUp()
    {
        $this->handler = new SkinHandler($this->getContainer(), $this->getStore(), [], []);
        parent::setUp();
    }

    protected function getPropertyValue($object, $property)
    {
        $refl = new \ReflectionObject($object);
        $repoProp = $refl->getProperty($property);
        $repoProp->setAccessible(true);
        return $repoProp->getValue($object);
    }

    /**
     * @return Container
     */
    protected function getContainer()
    {
        /*
         * 'module/pluginA@board/skin/pluginA@blue',
         * 'module/pluginA@forum/skin/pluginA@blue',
         */
        $container = Mockery::mock('\Xpressengine\Plugin\PluginRegister');

        $skinIds = [
            'module/pluginA@board/skin/pluginA@blue',
            'module/pluginA@board/skin/pluginA@red',
            'module/pluginA@forum/skin/pluginA@blue',
            'module/pluginA@forum/settingsSkin/pluginA@blue',
            'module/pluginA@forum/settingsSkin/pluginA@red',
            'module/pluginA@forum/settingsSkin/pluginA@blue',
        ];
        $skins = [];
        foreach ($skinIds as $id) {
            $skinClass = $this->makeSkinMock($id);
            $skins[$id] = $skinClass;
            $container->shouldReceive('get')->withArgs([$id])->andReturn($skinClass);
        }

        $container->shouldReceive('get')->withArgs(['noskin/skin'])->andReturnNull();
        $container->shouldReceive('get')->withArgs(['module/pluginA@board/skin'])->andReturn(
            array_splice($skins, 0, 2)
        );
        $container->shouldReceive('get')->withArgs(['module/pluginA@board/settingsSkin'])->andReturnNull();

        $container->shouldReceive('get')->withArgs(['module/pluginA@real/settingsSkin/test'])->andReturn(
            TestSkin::class
        );
        $container->shouldReceive('get')->withArgs(['module/pluginA@real/settingsSkin'])->andReturn(
            [
                'module/pluginA@real/settingsSkin/test' => TestSkin::class,
            ]
        );
        $container->shouldReceive('get')->withArgs(['module/pluginA@real/skin/test'])->andReturn(TestSkin::class);
        $container->shouldReceive('get')->withArgs(['module/pluginA@real/skin'])->andReturn(
            [
                'module/pluginA@real/skin/test' => TestSkin::class,
            ]
        );

        return $container;
    }

    /**
     * @return SkinInstanceStore
     */
    protected function getStore()
    {
        $store = Mockery::mock('Xpressengine\Skin\SkinInstanceStore');
        return $store;
    }

    /**
     * @param $id
     * @param $type
     *
     * @return Mockery\MockInterface
     */
    protected function makeSkinMock($id)
    {
        $postfix = str_replace(['/', '@'], '_', $id);
        $mock = \Mockery::mock(
            'alias:Skin_'.$postfix,
            'Xpressengine\Skin\AbstractSkin',
            [
                'getId' => $id,
                'getTitle' => 'skin for test',
            ]
        );
        return 'Skin_'.$postfix;
    }
}
