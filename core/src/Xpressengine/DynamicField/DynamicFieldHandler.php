<?php
/**
 * DynamicFieldHandler
 *
 * PHP version 7
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 * @mainpage    DynamicField
 * # Dynamic Field
 * 이 패키지는 database table의 column을 자유롭게 확장하여 사용하기 위한 것입니다.\n
 * XE3에서 table을 갖는 package나 plugin이 FieldType에서 지원하는
 * 형태의 column으로 table을 생성 하거나 수정합니다.\n
 * DynamicField는 이렇게 변경된 database table에
 * 데이터를 입/출력 할 수 있도록 도와주는 패키지 입니다.
 */

namespace Xpressengine\DynamicField;

use Illuminate\Support\Str;
use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Config\ConfigEntity;
use Illuminate\View\Factory as ViewFactory;
use Xpressengine\Plugin\PluginRegister;

/**
 * DynamicFieldHandler
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DynamicFieldHandler
{
    const CONFIG_NAME = 'DynamicField';

    /**
     * @var PluginRegister
     */
    protected $register;

    /**
     * database connection
     *
     * @var VirtualConnectionInterface
     */
    protected $connection;

    /**
     * @var ConfigHandler
     */
    protected $configHandler;

    /**
     * @var RegisterHandler
     */
    protected $registerHandler;

    /**
     * @var ViewFactory
     */
    protected $viewFactory;

    /**
     * create instance
     *
     * @param VirtualConnectionInterface $connection      database connection
     * @param ConfigHandler              $configHandler   config handler
     * @param RegisterHandler            $registerHandler register handler
     * @param ViewFactory                $viewFactory     view factory
     * @param PluginRegister             $pluginRegister  plugin register
     */
    public function __construct(
        VirtualConnectionInterface $connection,
        ConfigHandler $configHandler,
        RegisterHandler $registerHandler,
        ViewFactory $viewFactory,
        PluginRegister $pluginRegister
    ) {
        $this->connection = $connection;
        $this->configHandler = $configHandler;
        $this->registerHandler = $registerHandler;
        $this->viewFactory = $viewFactory;
        $this->register = $pluginRegister;
    }

    /**
     * get config handler
     *
     * @return ConfigHandler
     */
    public function getConfigHandler()
    {
        return $this->configHandler;
    }

    /**
     * get register handler
     *
     * @return RegisterHandler
     */
    public function getRegisterHandler()
    {
        return $this->registerHandler;
    }

    /**
     * get ViewFactory
     *
     * @return ViewFactory
     */
    public function getViewFactory()
    {
        return $this->viewFactory;
    }

    /**
     * get database connection
     *
     * @return VirtualConnectionInterface
     */
    public function connection()
    {
        return $this->connection;
    }

    /**
     * set database connection
     * DatabaseProxy 에 의해서 connection 을 변경 한다.
     *
     * @param VirtualConnectionInterface $connection database connection
     * @return void
     */
    public function setConnection(VirtualConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * DynamicField 는 기본으로 'id' 컬럼과 조인하도록 설정된다.
     * JoinColumn 정보가 없을 경우 기본 컬럼인 'id' 컬럼을 생성하여 리턴한다.
     *
     * @return ColumnEntity
     */
    private function getDefaultJoinColumn()
    {
        $column = new ColumnEntity(ConfigHandler::DEFAULT_JOIN_COLUMN_NAME, ColumnDataType::STRING);
        $column->setParams(array(36));
        return $column;
    }

    /**
     * DynamicField 생성
     * * ConfigManager 를 이용해 설정 정보를 저장
     * * FieldTypeManager 로 Dynamic Field Table 생성
     *
     * @param ConfigEntity $config insert config entity
     * @param ColumnEntity $column join column entity
     * @return void
     */
    public function create(ConfigEntity $config, ColumnEntity $column = null)
    {
        $group = $config->get('group');
        $id = $config->get('id');
        if ($group == null || $id == null) {
            throw new Exceptions\InvalidConfigException(['group' => $group, 'id' => $id]);
        }
        if ($this->configHandler->get($group, $id) !== null) {
            throw new Exceptions\AlreadyExistException;
        }

        if ($this->configHandler->parent($group) == null) {
            $this->configHandler->setParent($group);
        }
        if ($column === null) {
            $column = $this->getDefaultJoinColumn();
        }

        $config->set('joinColumnName', $column->name);
        $config->set('migration', true);

        $this->connection->beginTransaction();
        $this->configHandler->add($config);
        $type = $this->registerHandler->getType($this, $config->get('typeId'));
        $type->setConfig($config);

        if ($type->checkExistTypeTables() == false) {
            $type->createTypeTable();
        }

        $this->connection->commit();
    }

    /**
     * DynamicField 설정 변경
     *
     * @param ConfigEntity $config update config entity
     * @return void
     */
    public function put(ConfigEntity $config)
    {
        $this->configHandler->put($config);
    }

    /**
     * DynamicField 제거
     *
     * @param ConfigEntity $config config entity
     * @return void
     */
    public function drop(ConfigEntity $config)
    {
        $this->connection->beginTransaction();

        $this->configHandler->remove($config);
        $type = $this->registerHandler->getType($this, $config->get('typeId'));

        $type->setConfig($config);
        $type->dropData();

        $this->connection->commit();
    }

    /**
     * get dynamic fields by group name
     *
     * @param string $group config group name
     * @return array
     */
    public function gets($group)
    {
        $returnArr = [];

        $configs = $this->configHandler->gets($group);

        /**
         * @var \Xpressengine\Config\ConfigEntity $config
         */
        foreach ($configs as $config) {
            $returnArr[$config->get('id')] = $this->getByConfig($config);
        }

        return $returnArr;
    }

    /**
     * get Dynamic field table attributes by group name
     * @param string $group config group name
     * @return array
     */
    public function getDynamicAttributes($group)
    {
        $fieldTypes = $this->gets($group);
        $dynamicFieldsArrays = array_map(function (AbstractType $fieldType) {
            return array_keys($fieldType->getRules());
        }, $fieldTypes);
        return array_flatten($dynamicFieldsArrays);
    }

    /**
     * get dynamic field
     *
     * @param string $group config group name
     * @param string $id    field type id
     * @return AbstractType
     */
    public function get($group, $id)
    {
        $config = $this->configHandler->get($group, $id);
        if ($config == null) {
            return null;
        }

        return $this->getByConfig($config);
    }

    /**
     * @param string $id field type id
     * @return boolean
     */
    public function hasDynamicField($id)
    {
        $registerd = $this->register->get($id);

        if ($registerd === null) {
            return false;
        }

        return true;
    }

    /**
     * has dynamic field
     *
     * @param string $group config group name
     * @param string $id    field type id
     * @return bool
     */
    public function has($group, $id)
    {
        return $this->configHandler->get($group, $id) === null ? false : true;
    }

    /**
     * get type by dynamic field config entity
     *
     * @param ConfigEntity $config dynamic field config entity
     * @return AbstractType
     */
    public function getByConfig(ConfigEntity $config)
    {
        $type = $this->registerHandler->getType($this, $config->get('typeId'));
        $type->setConfig($config);
        $skin = $this->registerHandler->getSkin($this, $config->get('skinId'));
        $skin->setConfig($config);
        $type->setSkin($skin);
        return $type;
    }

    /**
     * get dynamic field without skin instance
     *
     * @param string $group config group name
     * @param string $id    field type id
     * @return AbstractType
     */
    public function getType($group, $id)
    {
        $config = $this->configHandler->get($group, $id);
        if ($config == null) {
            return null;
        }

        $type = $this->registerHandler->getType($this, $config->get('typeId'));
        $type->setConfig($config);

        return $type;
    }

    /**
     * get rules by dynamic field config entity
     *
     * @param ConfigEntity $config dynamic field config entity
     * @return array
     *
     * @deprecated instead `$type->getRules()`, 변경전 등록된 설정값 처리문제로 유지 됨. v3.1 에서 제거
     */
    public function getRules(ConfigEntity $config)
    {
        $type = $this->getByConfig($config);

        $rules = [];
        foreach ($type->getRules() as $columnName => $rule) {
            $id = snake_case($config->get('id'));
            if (Str::startsWith($columnName, $id . '_')) {
                $key = $columnName;
            } else {
                $key = snake_case($config->get('id')) . '_' . $columnName;
            }

            $rules[$key] = $rule;
        }

        return $rules;
    }
}
