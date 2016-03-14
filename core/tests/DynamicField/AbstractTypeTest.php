<?php
/**
 * AbstractTypeTest
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\Tests\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @mainpage    DynamicField
 */
namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit_Framework_TestCase;

/**
 * AbstractTypeTest
 *
 * @category    DynamicField
 * @package     Xpressengine\Tests\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class AbstractTypeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var m\MockInterface|\Xpressengine\DynamicField\DynamicFieldHandler
     */
    protected $handler;

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
        $handler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler');

        $this->handler = $handler;
    }

    /**
     * test type interface
     *
     * @return void
     */
    public function testGetProperty()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $typeInstance->shouldReceive('setColumns');
        $typeInstance->shouldReceive('setRules');
        $typeInstance->shouldReceive('setSettingsRules');

        $typeInstance::boot();

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('name');
        $property->setAccessible(true);
        $property->setValue($typeInstance, 'name');
        $this->assertEquals('name', $typeInstance->name());

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('description');
        $property->setAccessible(true);
        $property->setValue($typeInstance, 'description');
        $this->assertEquals('description', $typeInstance->description());

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, ['columns']);
        $this->assertEquals(['columns'], $typeInstance->columns());

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('rules');
        $property->setAccessible(true);
        $property->setValue($typeInstance, ['rules']);
        $this->assertEquals(['rules'], $typeInstance->getRules());

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('settingsRules');
        $property->setAccessible(true);
        $property->setValue($typeInstance, ['settingsRules']);
        $this->assertEquals(['settingsRules'], $typeInstance->getSettingsRules());
    }

    /**
     * test skin manage
     *
     * @return void
     */
    public function testSkin()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $skinInstance = m::mock('Xpressengine\DynamicField\AbstractSkin');

        $typeInstance->setSkin($skinInstance);
        $this->assertInstanceOf('Xpressengine\DynamicField\AbstractSkin', $typeInstance->getSkin());
    }

    /**
     * test config
     *
     * @return void
     */
    public function testConfig()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = m::mock('Xpressengine\Config\ConfigEntity');

        $typeInstance->setConfig($config);
        $this->assertInstanceOf('Xpressengine\Config\ConfigEntity', $typeInstance->getConfig());
    }

    /**
     * test create by create table method
     *
     * @return void
     */
    public function testCreateByCreateTableMethod()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $addColumn = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $addColumn->shouldReceive('add');

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, [$addColumn]);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('id');
        $config->shouldReceive('get')->with('revision')->andReturn(true);

        $typeInstance->setConfig($config);

        $column = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $column->shouldReceive('add');
        $column->shouldReceive('get')->with('name')->andReturn('id');

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('isTableMethodCreate')->once()->andReturn(true);
        $configHandler->shouldReceive('getTableName')->andReturn('tableName');
        $configHandler->shouldReceive('getRevisionTableName')->andReturn('revisionTableName');

        $schemaBuilder = m::mock('Illuminate\Database\Schema\Builder');
        $table = m::mock('Illuminate\Database\Schema\Blueprint');
        $table->shouldReceive('primary');
        $table->shouldReceive('string');
        $table->shouldReceive('index');
        $fluent = m::mock('Illuminate\Support\Fluent');
        $fluent->shouldReceive('default');
        $table->shouldReceive('integer')->andReturn($fluent);

        $schemaBuilder->shouldReceive('create')->with('tableName', m::on(function ($closure) use ($table) {
            call_user_func($closure, $table);

            return true;
        }));

        $schemaBuilder->shouldReceive('create')->with('revisionTableName', m::on(function ($closure) use ($table) {
            call_user_func($closure, $table);

            return true;
        }));

        $connection = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $connection->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('connection')->andReturn($connection);

        $typeInstance->create($column);
    }

    /**
     * test create by alter table method
     *
     * @return void
     */
    public function testCreateByTAlertTableMethod()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $addColumn = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $addColumn->shouldReceive('add');
        $addColumn->shouldReceive('get')->with('name');

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, [$addColumn]);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('id');
        $config->shouldReceive('get')->with('revision')->andReturn(true);

        $typeInstance->setConfig($config);

        $column = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $column->shouldReceive('add');

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('isTableMethodCreate')->once()->andReturn(false);
        $configHandler->shouldReceive('getTableName')->andReturn('tableName');
        $configHandler->shouldReceive('getRevisionTableName')->andReturn('revisionTableName');

        $schemaBuilder = m::mock('Illuminate\Database\Schema\Builder');
        $table = m::mock('Illuminate\Database\Schema\Blueprint');
        $table->shouldReceive('primary');
        $table->shouldReceive('string');
        $table->shouldReceive('index');
        $fluent = m::mock('Illuminate\Support\Fluent');
        $fluent->shouldReceive('default');
        $table->shouldReceive('integer')->andReturn($fluent);

        $schemaBuilder->shouldReceive('hasTable')->andReturn(true);
        $schemaBuilder->shouldReceive('hasColumn')->andReturn(false);
        $schemaBuilder->shouldReceive('table')->with('tableName', m::on(function ($closure) use ($table) {
            call_user_func($closure, $table);

            return true;
        }));

        $schemaBuilder->shouldReceive('table')->with('revisionTableName', m::on(function ($closure) use ($table) {
            call_user_func($closure, $table);

            return true;
        }));

        $connection = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $connection->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('connection')->andReturn($connection);

        $typeInstance->create($column);
    }

    /**
     * test drop by drop table method
     *
     * @return void
     */
    public function testDropByDropTableMethod()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('id');
        $config->shouldReceive('get')->with('revision')->andReturn(true);

        $typeInstance->setConfig($config);

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('isTableMethodCreate')->once()->andReturn(true);
        $configHandler->shouldReceive('getTableName')->andReturn('tableName');
        $configHandler->shouldReceive('getRevisionTableName')->andReturn('revisionTableName');

        $schemaBuilder = m::mock('Illuminate\Database\Schema\Builder');

        $schemaBuilder->shouldReceive('hasTable')->andReturn(true);
        $schemaBuilder->shouldReceive('drop');

        $connection = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $connection->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('connection')->andReturn($connection);

        $typeInstance->drop();
    }

    /**
     * test drop by alter table method
     *
     * @return void
     */
    public function testDropByAlterTableMethod()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('id');
        $config->shouldReceive('get')->with('revision')->andReturn(true);

        $typeInstance->setConfig($config);

        $column = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $column->shouldReceive('drop');

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('isTableMethodCreate')->once()->andReturn(false);
        $configHandler->shouldReceive('getTableName')->andReturn('tableName');
        $configHandler->shouldReceive('getRevisionTableName')->andReturn('revisionTableName');

        $schemaBuilder = m::mock('Illuminate\Database\Schema\Builder');
        $table = m::mock('Illuminate\Database\Schema\Blueprint');
        $table->shouldReceive('primary');
        $table->shouldReceive('string');
        $table->shouldReceive('index');
        $fluent = m::mock('Illuminate\Support\Fluent');
        $fluent->shouldReceive('default');
        $table->shouldReceive('integer')->andReturn($fluent);

        $schemaBuilder->shouldReceive('hasTable')->andReturn(true);
        $schemaBuilder->shouldReceive('hasColumn')->andReturn(false);
        $schemaBuilder->shouldReceive('table')->with('tableName', m::on(function ($closure) use ($table) {
            call_user_func($closure, $table);

            return true;
        }));

        $schemaBuilder->shouldReceive('table')->with('revisionTableName', m::on(function ($closure) use ($table) {
            call_user_func($closure, $table);

            return true;
        }));

        $connection = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $connection->shouldReceive('getSchemaBuilder')->andReturn($schemaBuilder);

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('connection')->andReturn($connection);

        $typeInstance->drop();
    }

    /**
     * test insert
     *
     * @return void
     */
    public function testInsert()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $addColumn = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $addColumn->shouldReceive('add');
        $addColumn->shouldReceive('get')->with('name')->andReturn('add1');

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, [$addColumn]);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('getTableName')->andReturn('tableName');

        $query = m::mock('Illuminate\Database\Query\Builder');
        $query->shouldReceive('insert');

        $connection = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $connection->shouldReceive('table')->andReturn($query);

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('connection')->andReturn($connection);

        $args = [
            'id' => 'id',
            'instanceIdAdd1' => 'value',
        ];
        $typeInstance->insert($args);
    }

    /**
     * test update
     *
     * @return void
     */
    public function testUpdate()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $addColumn = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $addColumn->shouldReceive('add');
        $addColumn->shouldReceive('get')->with('name')->andReturn('add1');

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, [$addColumn]);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('getTableName')->andReturn('tableName');

        $query = m::mock('Illuminate\Database\Query\Builder');
        $query->shouldReceive('where')->andReturnSelf();
        $query->shouldReceive('update');
        $query->shouldReceive('insert');
        $query->shouldReceive('first')->once()->andReturn(['id' => 'id']);

        $connection = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $connection->shouldReceive('table')->andReturn($query);

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('connection')->andReturn($connection);

        $args = [
            'id' => 'id',
            'instanceIdAdd1' => 'value',
        ];
        $typeInstance->update($args, [
            ['column' => 'id', 'operator' => '=', 'value' => 'id']
        ]);

        // use insert query
        $query->shouldReceive('first')->once()->andReturn(null);
        $typeInstance->update($args, [
            ['column' => 'id', 'operator' => '=', 'value' => 'id']
        ]);
    }

    /**
     * test delete
     *
     * @return void
     */
    public function testDelete()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $addColumn = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $addColumn->name = 'add1';
        $addColumn->shouldReceive('add');

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, [$addColumn]);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('getTableName')->andReturn('tableName');

        $query = m::mock('Illuminate\Database\Query\Builder');
        $query->shouldReceive('where')->andReturnSelf();
        $query->shouldReceive('delete');

        $connection = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $connection->shouldReceive('table')->andReturn($query);

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('connection')->andReturn($connection);

        $typeInstance->delete([
            ['column' => 'id', 'operator' => '=', 'value' => 'id']
        ]);
    }

    /**
     * test get
     *
     * @return void
     */
    public function testGet()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('use')->andReturn(true);
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('sortable')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('getTableName')->andReturn('tableName');

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);

        $query = m::mock('Xpressengine\Database\DynamicQuery');
        $query->shouldReceive('hasDynamicTable')->andReturn(false);
        $query->shouldReceive('setDynamicTable');

        $join = m::mock('Illuminate\Database\Query\JoinClause');
        $join->shouldReceive('on');

        $query->shouldReceive('leftJoin')->with('tableName', m::on(function ($closure) use ($join) {
            call_user_func($closure, $join);

            return true;
        }));

        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $typeInstance->get($query));

        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $typeInstance->first($query));
    }

    /**
     * test build wheres
     *
     * @return void
     */
    public function testWheres()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $addColumn = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $addColumn->shouldReceive('add');
        $addColumn->shouldReceive('get')->with('name')->andReturn('add1');

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, [$addColumn]);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $query = m::mock('Xpressengine\Database\DynamicQuery');
        $query->shouldReceive('where')->andReturnSelf();

        $params = [
            'id' => 'id',
            'instanceIdAdd1' => 'value',
        ];

        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $typeInstance->wheres($query, $params));
    }

    /**
     * test build orders
     *
     * @return void
     */
    public function testOrders()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $addColumn = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $addColumn->shouldReceive('get')->with('name')->andReturn('add1');
        $addColumn->shouldReceive('add');

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, [$addColumn]);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $query = m::mock('Xpressengine\Database\DynamicQuery');
        $query->shouldReceive('orderBy')->andReturnSelf();

        $params = [
            'instanceIdAdd1' => 'desc',
        ];
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $typeInstance->orders($query, $params));
    }

    /**
     * test insert revision
     *
     * @return void
     */
    public function testInsertRevision()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $addColumn = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $addColumn->shouldReceive('get')->with('name')->andReturn('add1');
        $addColumn->shouldReceive('add');

        $reflection = new \ReflectionClass(get_class($typeInstance));
        $property = $reflection->getProperty('columns');
        $property->setAccessible(true);
        $property->setValue($typeInstance, [$addColumn]);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('getRevisionTableName')->andReturn('revisionTableName');

        $query = m::mock('Illuminate\Database\Query\Builder');
        $query->shouldReceive('insert');

        $connection = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $connection->shouldReceive('table')->andReturn($query);

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);
        $handler->shouldReceive('connection')->andReturn($connection);

        $args = [
            'id' => 'id',
            'revisionId' => 'revisionId',
            'revisionNo' => 'revisionNo',
            'instanceIdAdd1' => 'value',
        ];
        $typeInstance->insertRevision($args);
    }

    /**
     * test join revision
     *
     * @return void
     */
    public function testJoinRevision()
    {
        $handler = $this->handler;

        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('sortable')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $configHandler = m::mock('Xpressengine\DynamicField\ConfigHandler');
        $configHandler->shouldReceive('getRevisionTableName')->andReturn('revisionTableName');

        $handler->shouldReceive('getConfigHandler')->andReturn($configHandler);

        $query = m::mock('Xpressengine\Database\DynamicQuery');
        $query->shouldReceive('hasDynamicTable')->andReturn(false);
        $query->shouldReceive('setDynamicTable');

        $join = m::mock('Illuminate\Database\Query\JoinClause');
        $join->shouldReceive('on')->andReturnSelf();

        $query->shouldReceive('leftJoin')->with('revisionTableName', m::on(function ($closure) use ($join) {
            call_user_func($closure, $join);

            return true;
        }));

        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $typeInstance->joinRevision($query));
    }

    /**
     * test get settings uri
     *
     * @return void
     */
    public function testSettingsURI()
    {
        $handler = $this->handler;
        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
            ->shouldAllowMockingProtectedMethods()->makePartial();

        $this->assertNull($typeInstance::getSettingsURI());
    }
}
