<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Config;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Config\ConfigManager;

class ConfigManagerTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testAddCreateNewAndReturnsConfig()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board';

        $repo->shouldReceive('find')->once()->with('default', 'board')->andReturnNull();
        $repo->shouldReceive('fetchAncestor')->with('default', 'board')->andReturn([]);
        $repo->shouldReceive('save')->once()->withAnyArgs()->andReturn($mockConfig);

        $instance = new ConfigManager($repo);

        $config = $instance->add('board', ['commentable' => false, 'downloadable' => true]);

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
    }

    public function testAddThrowsExceptionWhenExists()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);

        $instance = new ConfigManager($repo);

        try {
            $config = $instance->add('board.notice', ['commentable' => false, 'downloadable' => true]);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Config\Exceptions\DuplicateException', $e);
        }

    }

    public function testGetReturnsDefaultWhenNotExists()
    {
        list($repo) = $this->getMocks();

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturnNull();
        $instance = new ConfigManager($repo);

        $val = $instance->getVal('board.notice.listCount', 10);

        $this->assertEquals(10, $val);
    }

    public function testGetValReturnsValueWhenExists()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->name = 'board.notice';
        $mockConfig->shouldReceive('get')->with('listCount', null)->andReturn(10);

        $ancestor = m::mock('Xpressengine\Config\ConfigEntity');
        $ancestor->name = 'board';

        $mockConfig->shouldReceive('setParent')->once()->with($ancestor)->andReturnNull();

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([$ancestor]);

        $instance = new ConfigManager($repo);

        $val = $instance->getVal('board.notice.listCount');

        $this->assertEquals(10, $val);
    }

    public function testGetPureValReturnsPureValue()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->name = 'board.notice';
        $mockConfig->shouldReceive('getPure')->with('listCount', null)->andReturn(0);

        $ancestor = m::mock('Xpressengine\Config\ConfigEntity');
        $ancestor->name = 'board';

        $mockConfig->shouldReceive('setParent')->once()->with($ancestor)->andReturnNull();

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([$ancestor]);

        $instance = new ConfigManager($repo);

        $val = $instance->getPureVal('board.notice.listCount');

        $this->assertEquals(0, $val);
    }

    public function testGetsRetunsEntityObject()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->name = 'board.notice';

        $ancestor = m::mock('Xpressengine\Config\ConfigEntity');
        $ancestor->name = 'board';

        $mockConfig->shouldReceive('setParent')->once()->with($ancestor)->andReturnNull();

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([$ancestor]);

        $instance = new ConfigManager($repo);
        $config = $instance->get('board.notice');

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
    }

    public function testGetsOrNewRetunsEntityObjectEvenIfNotExists()
    {
        list($repo) = $this->getMocks();

        $ancestor = m::mock('Xpressengine\Config\ConfigEntity');
        $ancestor->name = 'board';

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturnNull();
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([$ancestor]);

        $instance = new ConfigManager($repo);
        $config = $instance->getOrNew('board.notice');

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
        $this->assertEquals('board.notice', $config->name);
    }

    public function testParserThrowsExceptionWhenGivenInvalidKey()
    {
        list($repo) = $this->getMocks();

        $instance = new ConfigManager($repo);

        try {
            $instance->setVal('listCount', 20);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Config\Exceptions\InvalidArgumentException', $e);
        }
    }

    public function testSet()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->name = 'board.notice';
        $mockConfig->shouldReceive('set')->with('listCount', 20)->andReturnNull();

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([]);
        $repo->shouldReceive('save')->once()->with($mockConfig)->andReturn($mockConfig);

        $instance = new ConfigManager($repo);

        $instance->setVal('board.notice.listCount', 20);
    }

    public function testSetCreateNewConfigWhenNotExists()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board';

        $repo->shouldReceive('find')->twice()->with('default', 'board')->andReturnNull();

        $repo->shouldReceive('fetchAncestor')->with('default', 'board')->andReturn([]);
        $repo->shouldReceive('save')->once()->withAnyArgs()->andReturn($mockConfig);

        $instance = new ConfigManager($repo);

        $instance->setVal('board.manage', 'me');
    }

    public function testSetToDesc()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->name = 'board.notice';
        $mockConfig->shouldReceive('set')->with('listCount', 20)->andReturnNull();
        $mockConfig->shouldReceive('getPure')->with('listCount')->andReturn(20);

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([]);
        $repo->shouldReceive('save')->once()->with($mockConfig)->andReturn($mockConfig);

        $mockDesc1 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockDesc1->shouldReceive('set')->with('listCount', 20)->andReturnNull();
        $mockDesc2 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockDesc2->shouldReceive('set')->with('listCount', 20)->andReturnNull();
        $mockDesc3 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockDesc3->shouldReceive('set')->with('listCount', 20)->andReturnNull();

        $repo->shouldReceive('fetchDescendant')->with('default', 'board.notice')->andReturn([$mockDesc1, $mockDesc2, $mockDesc3]);

        $repo->shouldReceive('save')->once()->with($mockDesc1)->andReturnNull();
        $repo->shouldReceive('save')->once()->with($mockDesc2)->andReturnNull();
        $repo->shouldReceive('save')->once()->with($mockDesc3)->andReturnNull();

        $instance = new ConfigManager($repo);

        $instance->setVal('board.notice.listCount', 20, true);
    }

    public function testSetsChangeValueAndReturns()
    {
        list($repo) = $this->getMocks();

        $func = function () {
            return 'called';
        };

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->name = 'board.notice';
        $mockConfig->shouldReceive('set')->once()->with('listCount', 20)->andReturnNull();
        $mockConfig->shouldReceive('get')->once()->with('listCount')->andReturn(20);
        $mockConfig->shouldReceive('set')->once()->with('downloadable', true)->andReturnNull();
        $mockConfig->shouldReceive('get')->once()->with('downloadable')->andReturn(true);
        $mockConfig->shouldReceive('set')->once()->with('callable', $func)->andReturnNull();
        $mockConfig->shouldReceive('get')->once()->with('callable')->andReturn($func());

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([]);
        $repo->shouldReceive('save')->once()->with($mockConfig)->andReturn($mockConfig);

        $instance = new ConfigManager($repo);

        $config = $instance->set(
            'board.notice',
            ['listCount' => 20, 'downloadable' => true, 'callable' => $func]
        );

        $this->assertEquals(20, $config->get('listCount'));
        $this->assertEquals(true, $config->get('downloadable'));
        $this->assertEquals('called', $config->get('callable'));
    }

    public function testSetsCreateNewConfigWhenNotExists()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board';
        $mockConfig->shouldReceive('get')->once()->with('listCount')->andReturn(20);
        $mockConfig->shouldReceive('get')->once()->with('downloadable')->andReturn(true);

        $repo->shouldReceive('find')->twice()->with('default', 'board')->andReturnNull();
        $repo->shouldReceive('fetchAncestor')->with('default', 'board')->andReturn([]);
        $repo->shouldReceive('save')->once()->withAnyArgs()->andReturn($mockConfig);
        $repo->shouldReceive('fetchDescendant')->with('default', 'board')->andReturn([]);

        $instance = new ConfigManager($repo);

        $config = $instance->set('board', ['listCount' => 20, 'downloadable' => true], true);

        $this->assertEquals(20, $config->get('listCount'));
        $this->assertEquals(true, $config->get('downloadable'));
    }

    public function testPutThrowExceptionWhenNotExists()
    {
        list($repo) = $this->getMocks();

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturnNull();

        $instance = new ConfigManager($repo);

        try {
            $instance->put('board.notice', ['listCount' => 20, 'downloadable' => true]);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Config\Exceptions\NotExistsException', $e);
        }

    }

    public function testPutChangeAllAndReturns()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->name = 'board.notice';
        $mockConfig->shouldReceive('set')->once()->with('listCount', 20)->andSet('listCount', 20);
        $mockConfig->shouldReceive('set')->once()->with('downloadable', true)->andSet('downloadable', true);
        $mockConfig->shouldReceive('clear')->andReturnNull();

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([]);
        $repo->shouldReceive('save')->once()->with($mockConfig)->andReturn($mockConfig);
        $repo->shouldReceive('fetchDescendant')->with('default', 'board.notice')->andReturn([]);

        $instance = new ConfigManager($repo);

        $config = $instance->put('board.notice', ['listCount' => 20, 'downloadable' => true], true);

        $this->assertEquals(20, $config->listCount);
        $this->assertEquals(true, $config->downloadable);
    }

    public function testModify()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.notice';

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([]);
        $repo->shouldReceive('save')->once()->with($mockConfig)->andReturn($mockConfig);

        $instance = new ConfigManager($repo);

        $config = $instance->modify($mockConfig);

        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $config);
    }

    public function testModifyThrowsExceptionWhenNotExists()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.notice';

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturnNull();

        $instance = new ConfigManager($repo);

        try {
            $instance->modify($mockConfig);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Config\Exceptions\NotExistsException', $e);
        }
    }

    public function testConveyNotExceptedItemCallClear()
    {
        list($repo) = $this->getMocks();
        $instance = new ConfigManager($repo);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.notice';

        $mockDesc1 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockDesc1->shouldReceive('clear')->once();
        $mockDesc2 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockDesc2->shouldReceive('clear')->once();

        $repo->shouldReceive('fetchDescendant')->once()->with('default', 'board.notice')->andReturn([$mockDesc1, $mockDesc2]);
        $repo->shouldReceive('save')->twice();


        $this->invokeMethod($instance, 'convey', [$mockConfig, function () { return true; }, null]);
    }

    public function testRemove()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.notice';

        $repo->shouldReceive('remove')->once()->with('default', 'board.notice')->andReturnNull();

        $instance = new ConfigManager($repo);

        $instance->remove($mockConfig);
    }

    public function testRemoveByName()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->name = 'board.notice';

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([]);
        $repo->shouldReceive('remove')->once()->with('default', 'board.notice')->andReturnNull();

        $instance = new ConfigManager($repo);

        $instance->removeByName('board.notice');
    }

    public function testChildrenReturnsAdjacencyConfigs()
    {
        list($repo) = $this->getMocks();

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.notice';
        $mockConfig->shouldReceive('getDepth')->andReturn(2);

        $mockBD1 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockBD1->name = 'board.notice.bd1';
        $mockBD1->shouldReceive('getDepth')->andReturn(3);

        $mockBD2 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockBD2->name = 'board.notice.bd2';
        $mockBD2->shouldReceive('getDepth')->andReturn(3);

        $mockBD3 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockBD3->name = 'board.notice.bd1.sub1';
        $mockBD3->shouldReceive('getDepth')->andReturn(4);

        $repo->shouldReceive('fetchDescendant')->once()->with('default', 'board.notice')->andReturn([$mockBD1, $mockBD2, $mockBD3]);
        $repo->shouldReceive('fetchAncestor')->andReturn([]);

        $instance = new ConfigManager($repo);

        $children = $instance->children($mockConfig);

        $this->assertEquals(2, count($children));

        $this->assertEquals('board.notice.bd1', $children[0]->name);
        $this->assertEquals('board.notice.bd2', $children[1]->name);
    }

    public function testValidatingThrowsExceptionWhenFail()
    {
        list($repo) = $this->getMocks();
        $instance = new ConfigManager($repo);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockValidator = m::mock('Illuminate\Validation\Validator');
        $mockValidator->shouldReceive('fails')->andReturn(true);
        $mockValidator->shouldReceive('messages')->andReturnSelf();
        $mockValidator->shouldReceive('first')->andReturn('Exception!!');


//        $validator->shouldReceive('validate')->once()->with($mockConfig)->andReturn($mockValidator);

        try {
            $this->invokeMethod($instance, 'validating', [$mockConfig]);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Config\Exceptions\ValidationException', $e);
        }
    }

    public function testSort()
    {
        list($repo) = $this->getMocks();
        $instance = new ConfigManager($repo);

        $mockConfig1 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig1->shouldReceive('getDepth')->andReturn(2);
        $mockConfig2 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig2->shouldReceive('getDepth')->andReturn(0);
        $mockConfig3 = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig3->shouldReceive('getDepth')->andReturn(1);

        // asc
        $configs = $this->invokeMethod($instance, 'sort', [[$mockConfig1, $mockConfig2, $mockConfig3]]);

        $this->assertEquals(0, current($configs)->getDepth());
        $this->assertEquals(1, next($configs)->getDepth());
        $this->assertEquals(2, next($configs)->getDepth());

        // desc
        $configs = $this->invokeMethod($instance, 'sort', [[$mockConfig1, $mockConfig2, $mockConfig3], 'desc']);

        $this->assertEquals(2, current($configs)->getDepth());
        $this->assertEquals(1, next($configs)->getDepth());
        $this->assertEquals(0, next($configs)->getDepth());
    }

    public function testMoveThrowsExceptionWhenGivenUnknownTo()
    {
        list($repo) = $this->getMocks();
        $instance = new ConfigManager($repo);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->site_key = 'default';

        $repo->shouldReceive('find')->once()->with('default', 'invalid.to')->andReturnNull();

        try {
            $instance->move($mockConfig, 'invalid.to');

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Config\Exceptions\InvalidArgumentException', $e);
        }
    }

    public function testMoveThrowsExceptionWhenNotTopLevelAndNotHasParent()
    {
        list($repo) = $this->getMocks();
        $instance = new ConfigManager($repo);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('getParent')->andReturnNull();
        $mockConfig->shouldReceive('getDepth')->andReturn(2);

        try {
            $instance->move($mockConfig);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Config\Exceptions\NoParentException', $e);
        }
    }

    public function testMoveFromTopToAnotherChild()
    {
        list($repo) = $this->getMocks();
        $instance = new ConfigManager($repo);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('getParent')->andReturnNull();
        $mockConfig->shouldReceive('getDepth')->andReturn(1);
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.notice';
        $mockConfig->shouldReceive('get')->with('listCount', null)->andReturn(10);

        $mockToConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockToConfig->name = 'board';

        $repo->shouldReceive('find')->once()->with('default', 'board')->andReturn($mockToConfig);
        $repo->shouldReceive('affiliate')->once()->with($mockConfig, 'board');


        $mockConfig->shouldReceive('setParent')->once()->with($mockToConfig)->andReturnNull();

        $repo->shouldReceive('find')->once()->with('default', 'board.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'board.notice')->andReturn([$mockToConfig]);


        $instance->move($mockConfig, 'board');
    }

    public function testMoveFromChildToTop()
    {
        list($repo) = $this->getMocks();
        $instance = new ConfigManager($repo);

        $mockParent = m::mock('Xpressengine\Config\ConfigEntity');

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('getParent')->andReturn($mockParent);
        $mockConfig->shouldReceive('getDepth')->andReturn(2);
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.notice';


        $repo->shouldReceive('foster')->once()->with($mockConfig, null);

        $repo->shouldReceive('find')->once()->with('default', 'notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'notice')->andReturn([]);

        $instance->move($mockConfig);
    }

    public function testMoveFromChildToAnotherChild()
    {
        list($repo) = $this->getMocks();
        $instance = new ConfigManager($repo);

        $mockParent = m::mock('Xpressengine\Config\ConfigEntity');

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('getParent')->andReturn($mockParent);
        $mockConfig->shouldReceive('getDepth')->andReturn(2);
        $mockConfig->site_key = 'default';
        $mockConfig->name = 'board.notice';

        $mockToConfig = m::mock('Xpressengine\Config\ConfigEntity');

        $repo->shouldReceive('find')->once()->with('default', 'valid.to')->andReturn($mockToConfig);
        $repo->shouldReceive('foster')->once()->with($mockConfig, 'valid.to');

        $mockConfig->shouldReceive('setParent')->once()->with($mockToConfig)->andReturnNull();

        $repo->shouldReceive('find')->once()->with('default', 'valid.to.notice')->andReturn($mockConfig);
        $repo->shouldReceive('fetchAncestor')->with('default', 'valid.to.notice')->andReturn([$mockToConfig]);

        $instance->move($mockConfig, 'valid.to');
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Config\ConfigRepository'),
        ];
    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
