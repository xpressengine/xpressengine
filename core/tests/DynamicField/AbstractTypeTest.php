<?php
/**
 * AbstractTypeTest
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\Tests\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 * @mainpage    DynamicField
 */

namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;

/**
 * AbstractTypeTest
 *
 * @category    DynamicField
 * @package     Xpressengine\Tests\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
    public function testAbstracts()
    {
        $handler = $this->handler;
        $typeInstance = new TestType($handler);

        $this->assertEquals('name', $typeInstance->name());
        $this->assertEquals('description', $typeInstance->description());
        $this->assertInstanceOf('Xpressengine\DynamicField\ColumnEntity', $typeInstance->getColumns()[0]);
        $this->assertEquals(['rules'], $typeInstance->getRules());
        $this->assertEquals(['settings_rules'], $typeInstance->getSettingsRules());
        $this->assertEquals('', $typeInstance->getSettingsView());
    }

    /**
     * test skin manage
     *
     * @return void
     */
    public function testSkin()
    {
        $handler = $this->handler;
        $typeInstance = new TestType($handler);
        $skinInstance = new TestSkin($handler);

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
        $typeInstance = new TestType($handler);

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
        $typeInstance = new TestType($handler);

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
        $typeInstance = new TestType($handler);

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
//        $handler = $this->handler;
//
//        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
//            ->shouldAllowMockingProtectedMethods()->makePartial();

        $handler = $this->handler;
        $typeInstance = new TestType($handler);

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
//        $handler = $this->handler;
//
//        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
//            ->shouldAllowMockingProtectedMethods()->makePartial();

        $handler = $this->handler;
        $typeInstance = new TestType($handler);

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
//        $handler = $this->handler;
//
//        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
//            ->shouldAllowMockingProtectedMethods()->makePartial();

        $handler = $this->handler;
        $typeInstance = new TestType($handler);

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
            'instanceIdId' => 'value',
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
//        $handler = $this->handler;
//
//        $typeInstance = m::mock('Xpressengine\DynamicField\AbstractType', [$handler])
//            ->shouldAllowMockingProtectedMethods()->makePartial();

        $handler = $this->handler;
        $typeInstance = new TestType($handler);

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
            'instanceIdId' => 'value',
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
        $typeInstance = new TestType($handler);

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
        $typeInstance = new TestType($handler);

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
        $typeInstance = new TestType($handler);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $query = m::mock('Xpressengine\Database\DynamicQuery');
        $query->shouldReceive('where')->andReturnSelf();

        $params = [
            'id' => 'id',
            'instanceIdId' => 'value',
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
        $typeInstance = new TestType($handler);

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->shouldReceive('get')->with('id')->andReturn('instanceId');
        $config->shouldReceive('get')->with('required')->andReturn(true);
        $config->shouldReceive('get')->with('joinColumnName')->andReturn('id');

        $typeInstance->setConfig($config);

        $query = m::mock('Xpressengine\Database\DynamicQuery');
        $query->shouldReceive('orderBy')->andReturnSelf();

        $params = [
            'instanceIdId' => 'desc',
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
        $typeInstance = new TestType($handler);

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
            'instanceIdId' => 'value',
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
        $typeInstance = new TestType($handler);

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
        $typeInstance = new TestType($handler);

        $this->assertNull($typeInstance::getSettingsURI());
    }
}

class TestType extends AbstractType
{

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'name';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return 'description';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        $column = m::mock('Xpressengine\DynamicField\ColumnEntity');
        $column->shouldReceive('add');
        $column->shouldReceive('get')->with('name')->andReturn('id');
        $column->shouldReceive('drop');

        return [$column];
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        return ['rules'];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return ['settings_rules'];
    }

    /**
     * Dynamic Field 설정 페이지에서 각 fieldType 에 필요한 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function getSettingsView(ConfigEntity $config = null)
    {
        return '';
    }
}

class TestSkin extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'skin_name';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'skin_path';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return ['skin_setting_rules'];
    }
}