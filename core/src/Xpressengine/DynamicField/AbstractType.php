<?php
/**
 * AbstractType
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\DynamicField;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Schema\Blueprint;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * AbstractType
 *
 * * DynamicField 의 타입을 정의할 때 사용되는 추상 클래스
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
    abstract public function getRules();

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
     * Dynamic Field 생성 시 처리해야 할 사항들
     *
     * @param ColumnEntity $column join column entity
     * @return void
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
     */
    private function createTable(ColumnEntity $column)
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
     */
    private function createRevisionTable(ColumnEntity $column)
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
     */
    private function createField()
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
     */
    private function createFieldRevision()
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
     */
    private function dropTable()
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
     */
    private function dropField()
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
        $insertParam['dynamic_field_target_id'] = $args[$config->get('joinColumnName')];
        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $insertParam[$key] = $args[$key];
            }
        }

        if (count($insertParam) > 1) {
            $this->handler->connection()->table($this->handler->getConfigHandler()->getTableName($config))
                ->insert($insertParam);
        }
    }

    /**
     * update, delete 처리 시 전달되는 wheres 에서 id를 추출 한다.
     *
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return array
     */
    private function parseWhere(array $wheres)
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
     * 생성된 Dynamic Field 테이블에 데이터 수정
     *
     * @param array $args   parameters
     * @param array $wheres Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function update(array $args, array $wheres)
    {
        $config = $this->config;

        $where = $this->parseWhere($wheres);

        if (isset($where[$config->get('joinColumnName')]) === false) {
            return null;
        }

        $updateParam = [];

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $updateParam[$key] = $args[$key];
            }
        }

        if (count($updateParam) > 0) {
            if ($this->handler->connection()->table($this->handler->getConfigHandler()->getTableName($config))
                    ->where('dynamic_field_target_id', '=', $where['id'])->first() != null
            ) {
                $this->handler->connection()->table($this->handler->getConfigHandler()->getTableName($config))
                    ->where('dynamic_field_target_id', '=', $where['id'])->update($updateParam);
            } else {
                $insertParam = $updateParam;
                $insertParam['dynamic_field_target_id'] = $where['id'];
                $this->handler->connection()->table($this->handler->getConfigHandler()->getTableName($config))
                    ->insert($insertParam);
            }
        }
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
        $where = $this->parseWhere($wheres);

        if (isset($where[$config->get('joinColumnName')]) === false) {
            throw new Exceptions\RequiredDynamicFieldException;
        }

        $this->handler->connection()->table($this->handler->getConfigHandler()->getTableName($config))
            ->where('dynamic_field_target_id', '=', $where['id'])->delete();
    }

    /**
     * $query 에 inner join 된 쿼리를 리턴
     *
     * @param DynamicQuery $query query builder
     * @return Builder
     */
    public function get(DynamicQuery $query)
    {
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
        $createTableName = $this->handler->getConfigHandler()->getTableName($config);
        if ($query->hasDynamicTable($createTableName) === true) {
            return $query;
        }

        $query->leftJoin($createTableName, function (JoinClause $join) use ($createTableName, $config, $baseTable) {
            $join->on(
                sprintf('%s.%s', $baseTable, $config->get('joinColumnName')),
                '=',
                sprintf('%s.dynamic_field_target_id', $createTableName)
            );
        });
        $query->setDynamicTable($createTableName);

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
                $query = $query->where($key, '=', $params[$key]);
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
                $query = $query->orderBy($key, '=', $params[$key]);
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
        $insertParam['dynamic_field_target_id'] = $args['id'];
        $insertParam['revision_id'] = $args['revisionId'];
        $insertParam['revision_no'] = $args['revisionNo'];
        foreach ($this->getColumns() as $column) {
            $key = $this->config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $insertParam[$key] = $args[$key];
            }
        }

        $this->handler->connection()->table(
            $this->handler->getConfigHandler()->getRevisionTableName($this->config)
        )->insert($insertParam);
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
        $table = $this->handler->getConfigHandler()->getRevisionTableName($config);
        if ($query->hasDynamicTable($table)) {
            return $query;
        }

        $query->leftJoin($table, function (JoinClause $join) use ($tableName, $table, $config) {
            $join->on(
                sprintf('%s.%s', $tableName, $config->get('joinColumnName')),
                '=',
                sprintf('%s.dynamic_field_target_id', $table)
            )->on(
                sprintf('%s.revision_id', $tableName),
                '=',
                sprintf('%s.revision_id', $table)
            );
        });
        $query->setDynamicTable($table);

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
}
