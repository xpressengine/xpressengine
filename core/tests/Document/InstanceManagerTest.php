<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Document;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Xpressengine\Document\InstanceManager;
use Xpressengine\Document\Models\Document;

/**
 * InstanceManagerTest
 * @package Xpressengine\Tests\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class InstanceManagerTest extends TestCase
{
    /**
     * @var M\MockInterface|\Xpressengine\Document\ConfigHandler
     */
    protected $configHandler;

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
     * set up
     *
     * @return void
     */
    public function setUp()
    {
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $conn->shouldReceive('beginTransaction');
        $conn->shouldReceive('commit');
        $conn->shouldReceive('getTablePrefix')->andReturn('table-prefix');

        $this->conn = $conn;

        $configHandler = m::mock('Xpressengine\Document\ConfigHandler');
        $this->configHandler = $configHandler;

    }

    /**
     * get config entity
     *
     * @return M\MockInterface|\Xpressengine\Config\ConfigEntity
     */
    private function getConfigEntity()
    {
        return m::mock('Xpressengine\Config\ConfigEntity');
    }

    /**
     * get schema builder
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    private function getSchemaBuilder()
    {
        $schemaBuilder = m::mock('Illuminate\Database\Schema\Builder');
        $schemaBuilder->shouldReceive('getColumnListing')->andReturn(['some']);
        $schemaBuilder->shouldReceive('create');
        $schemaBuilder->shouldReceive('drop');
        return $schemaBuilder;
    }

    /**
     * get connnection
     *
     * @return \Illuminate\Database\Connection
     */
    private function getConnection()
    {
        $connection = m::mock('Illuminate\Database\Connection');
        return $connection;
    }

    /**
     * test add instance
     *
     * @return void
     */
    public function testAdd()
    {
        $instanceId = 'instance-id';

        $configHandler = $this->configHandler;

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn($instanceId);

        $configHandler->shouldReceive('add');

        $schemaBuilder = $this->getSchemaBuilder();
        $schemaBuilder->shouldReceive('hasTable')->andReturn(false);
        $schemaBuilder->shouldReceive('setConnection');

        $this->conn->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);
        $this->conn->shouldReceive('master')->andReturn($this->getConnection());

        $manager = new InstanceManager($this->conn, $configHandler);

        $manager->add($config);
    }

    /**
     * test add instance
     *
     * @expectedException \Xpressengine\Document\Exceptions\DivisionTableAlreadyExistsException
     */
    public function testAddFailDivisionTableExist()
    {
        $instanceId = 'instance-id';

        $configHandler = $this->configHandler;

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn($instanceId);

        $configHandler->shouldReceive('add');

        $schemaBuilder = $this->getSchemaBuilder();
        $schemaBuilder->shouldReceive('hasTable')->andReturn(true);

        $this->conn->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);

        $manager = new InstanceManager($this->conn, $configHandler);

        $manager->add($config);
    }

    /**
     * test put instance config
     *
     * @return void
     */
    public function testPut()
    {
        $configHandler = $this->configHandler;
        $configHandler->shouldReceive('put');

        $manager = new InstanceManager($this->conn, $configHandler);

        $config = $this->getConfigEntity();
        $configHandler->shouldReceive('put');

        $manager->put($config);
    }

    /**
     * test remove instance
     *
     * @return void
     */
    public function testRemove()
    {
        $instanceId = 'instance-id';

        $configHandler = $this->configHandler;

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn($instanceId);

        $configHandler->shouldReceive('remove');

        $schemaBuilder = $this->getSchemaBuilder();
        $schemaBuilder->shouldReceive('hasTable')->andReturn(false);

        $this->conn->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);

        $manager = new InstanceManager($this->conn, $configHandler);

        $manager->remove($config);
    }

    /**
     * test remove instance
     *
     * @return void
     */
    public function testGetDivisionTableName()
    {
        $instanceId = 'instance-id';

        $configHandler = $this->configHandler;

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(false);
        $config->shouldReceive('get')->with('instanceId')->andReturn(null);

        $manager = new InstanceManager($this->conn, $configHandler);

        $this->assertEquals(Document::TABLE_NAME, $manager->getDivisionTableName($config));

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn(null);

        $manager = new InstanceManager($this->conn, $configHandler);

        $this->assertEquals(Document::TABLE_NAME, $manager->getDivisionTableName($config));

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn($instanceId);

        $manager = new InstanceManager($this->conn, $configHandler);

        $this->assertEquals(
            sprintf('%s_%s', Document::TABLE_NAME, $instanceId),
            $manager->getDivisionTableName($config)
        );
    }
}
