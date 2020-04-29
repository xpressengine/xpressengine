<?php
/**
 * AbstractType
 *
 * PHP version 7
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\DynamicField;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * AbstractType
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class AbstractType implements ComponentInterface
{
    use ComponentTrait;

    /**
     * @var DynamicFieldHandler
     */
    protected $handler;

    /**
     * field type name
     *
     * @var string
     */
    protected $name;

    /**
     * field type description
     *
     * @var string
     */
    protected $description;

    /**
     * database table's column
     * ColumnEntity 의 array
     *
     * @var ColumnEntity[]
     */
    protected $columns = [];

    /**
     * validation rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * validation settings rules
     *
     * @var array
     */
    protected $settingsRules = [];

    /**
     * @var ConfigEntity
     */
    protected $config;

    /**
     * @var AbstractSkin
     */
    protected $skin;

    /**
     * get field type name
     *
     * @return string
     */
    abstract public function name();

    /**
     * get field type description
     *
     * @return string
     */
    abstract public function description();

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    abstract public function getColumns();

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        $required = $this->config->get('required') === true;

        $rules = [];
        $names = array_map(function () {
            return '';
        }, $this->getColumns());

        foreach (array_merge($names, $this->rules) as $name => $rule) {
            $key = $this->config->get('id') . '_' . $name;

            if ($required == true) {
                $rules[$key] = ltrim($rule . '|required', '|');
            } else {
                $rules[$key] = 'nullable|' . $rule;
            }
        }

        return $rules;
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    abstract public function getSettingsRules();

    /**
     * Dynamic Field 설정 페이지에서 각 fieldType 에 필요한 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    abstract public function getSettingsView(ConfigEntity $config = null);

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
    }

    /**
     * create instance
     *
     * @param DynamicFieldHandler $handler dynamic field handler
     */
    public function __construct(DynamicFieldHandler $handler)
    {
        $this->handler = $handler;
        $this->name = $this->name();
        $this->description = $this->description();
        $this->columns = $this->getColumns();
    }

    /**
     * set skin instance
     *
     * @param AbstractSkin $skin skin
     * @return void
     */
    public function setSkin(AbstractSkin $skin)
    {
        $this->skin = $skin;
    }

    /**
     * get skin
     *
     * @return AbstractSkin
     */
    public function getSkin()
    {
        return $this->skin;
    }

    /**
     * set config
     *
     * @param ConfigEntity $config dynamic field config entity
     * @return void
     */
    public function setConfig(ConfigEntity $config)
    {
        $this->config = $config;
    }

    /**
     * get dynamic field config
     *
     * @return ConfigEntity
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * get dynamic field table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'field_' . $this->getPureTableName();
    }

    /**
     * get dynamic field revision table name
     *
     * @return string
     */
    public function getRevisionTableName()
    {
        return 'field_revision_' . $this->getPureTableName();
    }

    /**
     * get dynamic field type table name
     *
     * @return string
     */
    private function getPureTableName()
    {
        $tableName = $this->getId();
        $tableName = str_replace(RegisterHandler::FIELD_TYPE . '/', '', $tableName);
        $tableName = snake_case($tableName);
        $tableName = str_replace('@_', '@', $tableName);
        $tableName = str_replace('@', '_', $tableName);

        return $tableName;
    }

    /**
     * check exist dynamic field table and dynamic field revision table
     *
     * @return bool
     */
    public function checkExistTypeTables()
    {
        return $this->checkExistTable($this->getTableName()) && $this->checkExistTable($this->getRevisionTableName());
    }

    /**
     * check exist table by table name
     *
     * @param string $tableName check table name
     *
     * @return mixed
     */
    private function checkExistTable($tableName)
    {
        return $this->handler->connection()->getSchemaBuilder()->hasTable($tableName);
    }

    /**
     * create dynamic field tables
     *
     * @return void
     */
    public function createTypeTable()
    {
        $self = $this;

        //일반 테이블 생성
        if ($this->checkExistTable($this->getTableName()) == false) {
            $this->handler->connection()->getSchemaBuilder()->create(
                $this->getTableName(),
                function (Blueprint $table) use ($self) {
                    $table->string('field_id', 36);
                    $table->string('target_id', 36);
                    $table->string('group');

                    foreach ($self->getColumns() as $column) {
                        $column->add($table, '');
                    }

                    $table->index(['field_id', 'target_id', 'group'], 'index');
                }
            );
        }

        //revision 테이블 생성
        if ($this->checkExistTable($this->getRevisionTableName()) == false) {
            $this->handler->connection()->getSchemaBuilder()->create(
                $this->getRevisionTableName(),
                function (Blueprint $table) use ($self) {
                    $table->string('revision_id', 255);
                    $table->integer('revision_no')->default(0);
                    $table->string('field_id', 36);
                    $table->string('target_id', 36);
                    $table->string('group');

                    foreach ($self->getColumns() as $column) {
                        $column->add($table, '');
                    }

                    $table->primary(array('revision_id', 'field_id'), 'primaryKey');
                    $table->index(['field_id', 'target_id', 'group'], 'index');
                }
            );
        }
    }

    /**
     * delete dynamic field all data
     *
     * @return void
     */
    public function dropData()
    {
        $where  = [
            ['field_id', $this->config->get('id', '')],
            ['group', $this->config->get('group', '')]
        ];

        $this->handler->connection()->table($this->getTableName())
            ->where($where)->delete();
    }

    /**
     * Dynamic Field 생성 시 처리해야 할 사항들
     *
     * @param ColumnEntity $column join column entity
     * @return void
     *
     * @deprecated since version 3.0.1 instead $type->createTypeTable()
     */
    public function create(ColumnEntity $column)
    {
        if ($this->handler->getConfigHandler()->isTableMethodCreate($this->config)) {
            $this->createTable($column);
            $this->createRevisionTable($column);
        } else {
            $this->createField();
            $this->createFieldRevision();
        }
    }

    /**
     * Dynamic Field Type 테이블 생성
     *
     * @param ColumnEntity $column join column entity
     * @return void
     *
     * @deprecated since version 3.0.1 instead $type->createTypeTable()
     */
    protected function createTable(ColumnEntity $column)
    {
        $self = $this;
        $this->handler->connection()->getSchemaBuilder()->create(
            $this->handler->getConfigHandler()->getTableName($this->config),
            function (Blueprint $table) use ($column, $self) {
                $column->add($table, 'dynamic_field_target');

                /**
                 * @var ColumnEntity $addColumn
                 */
                foreach ($self->getColumns() as $addColumn) {
                    $addColumn->add($table, $self->config->get('id'));
                }
                $table->primary(array($column->name), 'primaryKey');
            }
        );
    }

    /**
     * Dynamic Field Type revision 테이블 생성
     *
     * @param ColumnEntity $column join column entity
     * @return void
     *
     * @deprecated since version 3.0.1 instead $type->createTypeTable()
     */
    protected function createRevisionTable(ColumnEntity $column)
    {
        // create revision table
        if ($this->config->get('revision') === true) {
            $self = $this;

            $this->handler->connection()->getSchemaBuilder()->create(
                $this->handler->getConfigHandler()->getRevisionTableName($this->config),
                function (Blueprint $table) use ($column, $self) {
                    $table->string('revision_id', 255);
                    $table->integer('revision_no')->default(0);

                    $column->add($table);

                    /**
                     * @var ColumnEntity $addColumn
                     */
                    foreach ($self->getColumns() as $addColumn) {
                        $addColumn->add($table, $self->config->get('id'));
                    }

                    $table->primary(array('revision_id'), 'primaryKey');
                    $table->index($column->name, $column->name);
                }
            );
        }
    }

    /**
     * Dynamic Field 생성 시 alter table 로 처리
     * 이 기능은 관리자에서 지원하지 않음
     * 테이블 수정 시 발생항할 수있는 문제가 있기 때문에 기능만 제공
     * 이 기능을 사용하면서 방생하는 문제는 사용자 책임
     *
     * @return void
     *
     * @deprecated since version 3.0.1 instead $type->createTypeTable()
     */
    protected function createField()
    {
        $self = $this;
        $schema = $this->handler->connection()->getSchemaBuilder();

        $tableName = $this->handler->getConfigHandler()->getTableName($this->config);
        if ($schema->hasTable($tableName) === false) {
            throw new Exceptions\NotExistRevisionTableException;
        }

        foreach ($self->getColumns() as $column) {
            if ($schema->hasColumn($tableName, $column->name) === true) {
                throw new Exceptions\AlreadyExistColumnException;
            }
        }
        $this->handler->connection()->getSchemaBuilder()->table(
            $tableName,
            function (Blueprint $table) use ($self) {
                /**
                 * @var ColumnEntity $column
                 */
                foreach ($self->getColumns() as $column) {
                    $column->add($table, $self->config->get('id'));
                }
            }
        );
    }

    /**
     * Dynamic Field 생성 시 alter table 로 revision table 처리
     * 이 기능은 관리자에서 지원하지 않음
     * 테이블 수정 시 발생항할 수있는 문제가 있기 때문에 기능만 제공
     * 이 기능을 사용하면서 방생하는 문제는 사용자 책임
     *
     * @return void
     *
     * @deprecated since version 3.0.1 instead $type->createTypeTable()
     */
    protected function createFieldRevision()
    {
        if ($this->config->get('revision') == true) {
            $self = $this;
            $schema = $this->handler->connection()->getSchemaBuilder();

            $tableName = $this->handler->getConfigHandler()->getRevisionTableName($this->config);
            if ($schema->hasTable($tableName) === false) {
                throw new Exceptions\NotExistRevisionTableException;
            }

            foreach ($self->getColumns() as $column) {
                if ($schema->hasColumn($tableName, $column->name) === true) {
                    throw new Exceptions\AlreadyExistColumnException;
                }
            }
            $this->handler->connection()->getSchemaBuilder()->table(
                $tableName,
                function (Blueprint $table) use ($self) {
                    /**
                     * @var ColumnEntity $column
                     */
                    foreach ($self->getColumns() as $column) {
                        $column->add($table, $self->config->get('id'));
                    }
                }
            );
        }
    }

    /**
     * Dynamic Field 삭제 시 처리해야 할 사항들
     *
     * @return void
     *
     * @deprecated since version 3.0.1 instead $type->dropData()
     */
    public function drop()
    {
        if ($this->handler->getConfigHandler()->isTableMethodCreate($this->config)) {
            $this->dropTable();
        } else {
            $this->dropField();
        }
    }

    /**
     * Dynamic Field 삭제 시 테이블 삭제
     *
     * @return void
     *
     * @deprecated since version 3.0.1 instead $type->dropData()
     */
    protected function dropTable()
    {
        /**
         * @param \Illuminate\Database\Schema\Builder $schema
         */
        $schema = $this->handler->connection()->getSchemaBuilder();

        $tableName = $this->handler->getConfigHandler()->getTableName($this->config);
        if ($schema->hasTable($tableName) === false) {
            throw new Exceptions\NotExistTableException;
        }
        $schema->drop($tableName);

        $tableName = $this->handler->getConfigHandler()->getRevisionTableName($this->config);
        if ($this->config->get('revision') == true) {
            if ($schema->hasTable($tableName) === false) {
                throw new Exceptions\NotExistRevisionTableException;
            }
            $schema->drop($tableName);
        }
    }

    /**
     * Dynamic Field 삭제 시 alter table 로 처리
     *
     * @return void
     *
     * @deprecated since version 3.0.1 instead $type->dropData()
     */
    protected function dropField()
    {
        $self = $this;
        $schema = $this->handler->connection()->getSchemaBuilder();

        $tableName = $this->handler->getConfigHandler()->getTableName($this->config);
        if ($schema->hasTable($tableName) === false) {
            throw new Exceptions\NotExistRevisionTableException;
        }

        foreach ($this->getColumns() as $column) {
            if ($schema->hasColumn($tableName, $column->name) === true) {
                throw new Exceptions\AlreadyExistColumnException;
            }
        }
        $this->handler->connection()->getSchemaBuilder()->table(
            $tableName,
            function (Blueprint $table) use ($self) {
                /**
                 * @var ColumnEntity $column
                 */
                foreach ($self->getColumns() as $column) {
                    $column->drop($table, $self->config->get('id'));
                }
            }
        );

        if ($this->config->get('revision') == true) {
            $tableName = $this->handler->getConfigHandler()->getRevisionTableName($this->config);
            if ($schema->hasTable($tableName) === false) {
                throw new Exceptions\NotExistRevisionTableException;
            }

            foreach ($self->getColumns() as $column) {
                if ($schema->hasColumn($tableName, $column->name) === true) {
                    throw new Exceptions\AlreadyExistColumnException;
                }
            }
            $this->handler->connection()->getSchemaBuilder()->table(
                $tableName,
                function (Blueprint $table) use ($self) {
                    /**
                     * @var ColumnEntity $column
                     */
                    foreach ($self->getColumns() as $column) {
                        $column->drop($table);
                    }
                }
            );
        }
    }

    /**
     * 생성된 Dynamic Field 테이블에 데이터 입력
     *
     * @param array $args parameters
     * @return void
     */
    public function insert(array $args)
    {
        $config = $this->config;

        if (isset($args[$config->get('joinColumnName')]) === false) {
            throw new Exceptions\RequiredJoinColumnException;
        }

        $insertParam = [];
        $insertParam['field_id'] = $config->get('id');
        $insertParam['target_id'] = $args[$config->get('joinColumnName')];
        $insertParam['group'] = $config->get('group');

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key]) == true) {
                $insertParam[$column->name] = $args[$key];
            }
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.before_insert', $config->get('group'), $config->get('id'))
        );

        if (count($insertParam) > 1) {
            $this->handler->connection()->table($this->getTableName())->insert($insertParam);
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.after_insert', $config->get('group'), $config->get('id'))
        );
    }

    /**
     * update, delete 처리 시 전달되는 wheres 에서 id를 추출 한다.
     *
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return array
     *
     * @deprecated since version 3.0.1 instead $type->getWhere()
     */
    protected function parseWhere(array $wheres)
    {
        $where = [];
        foreach ($wheres as $arr) {
            // check alias
            $columnInfo = explode('.', $arr['column']);
            if (count($columnInfo) === 1) {
                $column = $columnInfo[0];
            } else {
                $column = $columnInfo[1];
            }

            if ($column == 'id' && $arr['operator'] == '=') {
                $where['id'] = $arr['value'];
            }
        }

        return $where;
    }

    /**
     * get where
     *
     * @param array        $wheres wheres
     * @param ConfigEntity $config config entity
     *
     * @return array
     */
    public function getWhere($wheres, ConfigEntity $config)
    {
        $where = [];
        foreach ($wheres as $arr) {
            // check alias
            $columnInfo = explode('.', $arr['column']);
            if (count($columnInfo) === 1) {
                $column = $columnInfo[0];
            } else {
                $column = $columnInfo[1];
            }

            if ($column == 'id' && $arr['operator'] == '=') {
                $where['target_id'] = $arr['value'];
            }
        }

        if ($group = $config->get('group', null)) {
            $where['group'] = $group;
        }

        if ($fieldId = $config->get('id', null)) {
            $where['field_id'] = $fieldId;
        }

        return $where;
    }

    /**
     * 생성된 Dynamic Field 테이블에 데이터 수정
     *
     * @param array $args   parameters
     * @param array $wheres Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function update(array $args, array $wheres)
    {
        $config = $this->config;
        $type = $this->handler->getRegisterHandler()->getType($this->handler, $config->get('typeId'));

        $where = $this->getWhere($wheres, $config);

        if (isset($where['target_id']) === false) {
            return null;
        }

        foreach ($args as $index => $arg) {
            if ($arg == null) {
                $args[$index] = '';
            }
        }

        $updateParam = [];
        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $updateParam[$column->name] = $args[$key];
            }
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.before_update', $config->get('group'), $config->get('id'))
        );

        if (count($updateParam) > 0) {
            if ($this->handler->connection()->table($type->getTableName())
                    ->where($where)->first() != null
            ) {
                $this->handler->connection()->table($type->getTableName())
                    ->where($where)->update($updateParam);
            } else {
                $insertParam = $updateParam;
                $insertParam['target_id'] = $where['target_id'];
                $insertParam['field_id'] = $config->get('id');
                $insertParam['group'] = $config->get('group');

                $this->handler->connection()->table($type->getTableName())
                    ->insert($insertParam);
            }
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.after_update', $config->get('group'), $config->get('id'))
        );
    }

    /**
     * 생성된 Dynamic Field 테이블에 데이터 삭제
     *
     * @param array $wheres Illuminate\Database\Query\Builder's wheres attribute wheres attribute
     * @return void
     */
    public function delete(array $wheres)
    {
        $config = $this->config;
        $type = $this->handler->getRegisterHandler()->getType($this->handler, $config->get('typeId'));
        $where = $this->getWhere($wheres, $config);

        if (isset($where['target_id']) === false) {
            throw new Exceptions\RequiredDynamicFieldException;
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.before_delete', $config->get('group'), $config->get('id'))
        );

        $this->handler->connection()->table($type->getTableName())->where($where)->delete();

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.after_delete', $config->get('group'), $config->get('id'))
        );
    }

    /**
     * $query 에 inner join 된 쿼리를 리턴
     *
     * @param DynamicQuery $query query builder
     * @return Builder
     */
    public function get(DynamicQuery $query)
    {
        if ($this->checkExistTypeTables() == false) {
            $this->createTypeTable();
        }

        $config = $this->config;
        if ($config->get('sortable') === false && $config->get('searchable') === false) {
            return $query;
        }

        return $this->join($query, $config);
    }

    /**
     * $query 에 outer join 된 쿼리를 리턴
     *
     * @param DynamicQuery $query query builder
     * @return Builder
     */
    public function first(DynamicQuery $query)
    {
        return $this->join($query, $this->config);
    }

    /**
     * table join
     *
     * @param DynamicQuery $query  query builder
     * @param ConfigEntity $config config entity
     * @return Builder
     */
    public function join(DynamicQuery $query, ConfigEntity $config = null)
    {
        if ($config === null) {
            $config = $this->config;
        }

        if ($config->get('use') === false) {
            return $query;
        }

        $baseTable = $query->from;

        $type = $this->handler->getRegisterHandler()->getType($this->handler, $config->get('typeId'));
        $tablePrefix = $this->handler->connection()->getTablePrefix();

        $createTableName = $type->getTableName();
        if ($query->hasDynamicTable($config->get('group') . '_' . $config->get('id')) === true) {
            return $query;
        }

        $rawString = sprintf('%s.*', $tablePrefix . $baseTable);
        foreach ($type->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            $rawString .= sprintf(', %s.%s as %s', $tablePrefix . $config->get('id'), $column->name, $key);
        }

        $query->leftJoin(
            sprintf('%s as %s', $createTableName, $config->get('id')),
            function (JoinClause $join) use ($createTableName, $config, $baseTable) {
                $join->on(
                    sprintf('%s.%s', $baseTable, $config->get('joinColumnName')),
                    '=',
                    sprintf('%s.target_id', $config->get('id'))
                )->where($config->get('id') . '.field_id', $config->get('id'));
            }
        )->selectRaw($rawString);

        $query->setDynamicTable($config->get('group') . '_' . $config->get('id'));

        return $query;
    }

    /**
     * query where 처리
     *
     * @param DynamicQuery $query  query builder
     * @param array        $params parameters for search
     * @return Builder
     */
    public function wheres(DynamicQuery $query, array $params)
    {
        $config = $this->config;
        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;
            if (isset($params[$key]) && $params[$key] != '') {
                $value = $params[$key];
                $operator = '=';
                if (is_array($params[$key])) {
                    list($value, $operator) = $params[$key];
                }

                $columnName = $config->get('id') . '.' . $column->name;
                $query = $query->where($columnName, $operator, $value);
            }
        }

        return $query;
    }

    /**
     * query order 처리
     *
     * @param DynamicQuery $query  query builder
     * @param array        $params parameters for search
     * @return Builder
     */
    public function orders(DynamicQuery $query, array $params)
    {
        $config = $this->config;
        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($params[$key])) {
                $query = $query->orderBy($key, $params[$key]);
            }
        }

        return $query;
    }

    /**
     * 생성된 Dynamic Field revision 테이블에 데이터 입력
     *
     * @param array $args parameters
     * @return void
     */
    public function insertRevision(array $args)
    {
        if (isset($args['id']) === false) {
            throw new Exceptions\RequiredDynamicFieldException;
        }

        $insertParam = [];
        $insertParam['target_id'] = $args['id'];
        $insertParam['group'] = $this->config->get('group');
        $insertParam['field_id'] = $this->config->get('id');
        $insertParam['revision_id'] = $args['revision_id'];
        $insertParam['revision_no'] = $args['revision_no'];

        foreach ($this->getColumns() as $column) {
            $key = $this->config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $insertParam[$column->name] = $args[$key];
            }
        }

        $this->handler->connection()->table($this->getRevisionTableName())->insert($insertParam);
    }

    /**
     * $query 에 join 된 쿼리를 리턴
     *
     * @param DynamicQuery $query query builder
     * @return Builder
     */
    public function joinRevision(DynamicQuery $query)
    {
        $config = $this->config;
        $tableName = $query->from;

        $table = $this->getRevisionTableName();
        if ($query->hasDynamicTable($config->get('group') . '_' . $config->get('id')) == true) {
            return $query;
        }

        $query->leftJoin($table, function (JoinClause $join) use ($tableName, $table, $config) {
            $join->on(
                sprintf('%s.%s', $tableName, $config->get('joinColumnName')),
                '=',
                sprintf('%s.target_id', $table)
            )->on(
                sprintf('%s.revision_id', $tableName),
                '=',
                sprintf('%s.revision_id', $table)
            )->on(sprintf('%s.group', $table), '=', $config->get('group'));
        });
        $query->setDynamicTable($config->get('group') . '_' . $config->get('id'));

        return $query;
    }

    /**
     * get manage uri
     *
     * @return null|string
     */
    public static function getSettingsURI()
    {
        return null;
    }

    /**
     * Determine if a item is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getConfig()->get('use') === true;
    }
}
