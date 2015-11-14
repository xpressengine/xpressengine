<?php
/**
 *
 */
namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\DynamicField\RevisionManager;

/**
 * Class RevisionManagerTest
 * @package Xpressengine\Tests\DynamicField
 */
class RevisionManagerTest extends PHPUnit_Framework_TestCase
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
        $query = m::mock('Illuminate\Database\Query\Builder');

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

        $this->assertInstanceOf('Illuminate\Database\Query\Builder', $revision->join($configs, $query));
    }
}