<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\DynamicField\RevisionManager;

/**
 * Class RevisionManagerTest
 * @package Xpressengine\Tests\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class RevisionManagerTest extends TestCase
{
    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * test manager
     *
     * @return void
     */
    public function testManager()
    {
        $query = m::mock('Xpressengine\Database\DynamicQuery');

        $type = m::mock('Xpressengine\DynamicField\AbstractType');
        $type->shouldReceive('insertRevision');
        $type->shouldReceive('setConfig');
        $type->shouldReceive('joinRevision')->andReturn($query);

        $registerHandler = m::mock('Xpressengine\DynamicField\RegisterHandler');
        $registerHandler->shouldReceive('getType')->andReturn($type);

        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');
        $handler->shouldReceive('getRegisterHandler')->andReturn($registerHandler);

        $revision = new RevisionManager($handler);

        $this->assertInstanceOf('Xpressengine\DynamicField\DynamicFieldHandler', $revision->getHandler());

        $config1 = m::mock('Xpressengine\Config\ConfigEntity');
        $config1->shouldReceive('get')->with('typeId')->andReturn('typeId');

        $configs = [
            $config1,
        ];

        $revision->add($configs, ['data'=>'data']);

        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $revision->join($configs, $query));
    }
}
