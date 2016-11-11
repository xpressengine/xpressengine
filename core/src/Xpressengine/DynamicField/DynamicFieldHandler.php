<?php
/**
 * DynamicFieldHandler
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Config\ConfigEntity;
use Illuminate\View\Factory as ViewFactory;

/**
 * DynamicFieldHandler
 *
 * * Xpressengine\Database 의 ProxyManager 에 DatabaseProxy 를 등록
 * * ProxyManager 의 인터페이스를 이용해서 DynamicField 데이터 처리
 * * DynamicFieldHandler 를 이용해 인스턴스 관리
 *
 * ## app binding
 * * xe.dynamicField 로 바인딩 되어 있음
 * * DynamicField facade 제공
 *
 * ## 사용법
 * Xpressengine\Database 패키지에서 처리하기 위해 ProxyInterface 를 사용함
 *
 * ### $group
 * * DynamicField 를 생성할 때 사용 한 별칭
 * * DynamicField 는 Table 단위로 관리되지 않음
 * * DynamicField 는 instance 별로 관리될 수 있음
 *
 * ### 관리자 Section
 * * App\Sections\DynamicFieldSection 을 이용해서 설정
 *
 * ### DynamicField 출력
 * * Document 에 추가된 Dynamic field 를 blade 에서 출력
 * ```php
 * @if (($fieldType = XeDynamicField::get($config->get('documentGroup'), $columnName)) != null)
 *   <div class="__xe_{{$columnName}} __xe_section">
 *      {!! $fieldType->getSkin()->show($item->getAttributes()) !!}
 *   </div>
 * @endif
 * ```
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DynamicFieldHandler
{
    const CONFIG_NAME = 'DynamicField';

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
     */
    public function __construct(
        VirtualConnectionInterface $connection,
        ConfigHandler $configHandler,
        RegisterHandler $registerHandler,
        ViewFactory $viewFactory
    ) {
        $this->connection = $connection;
        $this->configHandler = $configHandler;
        $this->registerHandler = $registerHandler;
        $this->viewFactory = $viewFactory;
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
            throw new Exceptions\InvalidConfigException;
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

        $this->connection->beginTransaction();
        $this->configHandler->add($config);
        $type = $this->registerHandler->getType($this, $config->get('typeId'));
        $type->setConfig($config);
        $type->create($column);
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
        $type->drop();
        $this->connection->commit();
    }

    /**
     * get dynamic fields by group name
     *
     * @param string $group config group name
     * @return \Generator
     */
    public function gets($group)
    {
        $configs = $this->configHandler->gets($group);

        /**
         * @var \Xpressengine\Config\ConfigEntity $config
         */
        foreach ($configs as $config) {
            yield $config->get('id') => $this->getByConfig($config);
        }
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
     * has dynamic field
     *
     * @param string $group config group name
     * @param string $id    field type id
     * @return bool
     */
    public function has($group, $id)
    {
        return $this->configHandler->get($group, $id) === null? false : true;
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
     */
    public function getRules(ConfigEntity $config)
    {
        $type = $this->getByConfig($config);

        $rules = [];
        foreach ($type->getRules() as $columnName => $rule) {
            $key = camel_case($config->get('id') . '_' . $columnName);
            $rules[$key] = $rule;
        }

        return $rules;
    }
}
