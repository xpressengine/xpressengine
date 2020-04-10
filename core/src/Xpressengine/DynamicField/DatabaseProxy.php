<?php
/**
 * DatabaseProxy
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

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\Database\ProxyInterface;
use Xpressengine\Config\ConfigEntity;

/**
 * DatabaseProxy
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DatabaseProxy implements ProxyInterface
{

    /**
     * @var DynamicFieldHandler
     */
    protected $handler;

    /**
     * Database proxy manager options
     * @var array
     */
    protected $options;

    /**
     * dynamic field group name
     *
     * @var string
     */
    protected $group;

    /**
     * @var bool
     */
    protected $revision = false;

    /**
     * create instance
     *
     * @param DynamicFieldHandler $handler dynamic field handler
     */
    public function __construct(DynamicFieldHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * get configs
     *
     * @return array
     */
    private function getConfigs()
    {
        return $this->handler->getConfigHandler()->gets($this->group);
    }

    /**
     * 테이블 생성 방식인지 확인
     *
     * @param ConfigEntity $config config entity
     * @return bool
     */
    private function isTableMethodCreate(ConfigEntity $config)
    {
        return $this->handler->getConfigHandler()->isTableMethodCreate($config);
    }

    /**
     * get dynamic field type
     *
     * @param string $id id
     * @return AbstractType
     */
    private function getType($id)
    {
        return $this->handler->getRegisterHandler()->getType($this->handler, $id);
    }

    /**
     * set database connection and options
     * Dynamic field 는 'id', 'group' 옵션을 갖는다.
     * 'id' 는 instance id 와 같이 테이블 기준이 아니라 인스턴스 기준으로
     * DynamicField 를 사용해야할 때 설정한다.(예: document, comment)
     * 'group' 은 별도의 명칭을 만들어 사용하고자 할 경우 설정
     *
     * @param VirtualConnectionInterface $conn    database connection
     * @param array                      $options options
     * @return void
     */
    public function set(VirtualConnectionInterface $conn, array $options)
    {
        $this->handler->setConnection($conn);
        $this->options = $options;

        if (isset($this->options['table']) == false) {
            throw new Exceptions\InvalidOptionException;
        }

        $this->group = $this->options['table'];
        if (isset($this->options['id'])) {
            $this->group = $this->options['table'] . '_' .  $this->options['id'];
        }

        if (isset($this->options['group'])) {
            $this->group = $this->options['group'];
        }

        if (isset($this->options['revision'])) {
            $this->revision = $this->options['revision'];
        } else {
            $this->revision = false;
        }
    }

    /**
     * dynamic field 데이터 등록
     *
     * @param array $args insert data parameters
     * @return void
     */
    public function insert(array $args)
    {
        /**
         * @var ConfigEntity $config
         */
        foreach ($this->getConfigs() as $config) {
            if ($config->get('use') === true) {
                $type = $this->getType($config->get('typeId'));
                $type->setConfig($config);
                if ($this->revision == true) {
                    $type->insertRevision($args);
                } else {
                    $type->insert($args);
                }
            }
        }
    }

    /**
     * DynamicField 데이터 수정
     *
     * @param array $args   update data parameters
     * @param array $wheres Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function update(array $args, array $wheres = [])
    {
        /**
         * @var ConfigEntity $config
         */
        foreach ($this->getConfigs() as $config) {
            if ($config->get('use') === true) {
                $type = $this->getType($config->get('typeId'));
                $type->setConfig($config);
                $type->update($args, $wheres);
            }
        }
    }

    /**
     * DynamicField 데이터 삭제
     *
     * @param array $wheres Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function delete(array $wheres = null)
    {
        /**
         * @var ConfigEntity $config
         */
        foreach ($this->getConfigs() as $config) {
            $type = $this->getType($config->get('typeId'));
            $type->setConfig($config);
            $type->delete($wheres);
        }
    }

    /**
     * Builder 에서 get()메소드 실행 시 join 처리
     *
     * @param DynamicQuery $query query builder
     * @return DynamicQuery
     */
    public function get(DynamicQuery $query)
    {
        /**
         * @var ConfigEntity $config
         */
        foreach ($this->getConfigs() as $config) {
            if ($this->isTableMethodCreate($config)) {
                $type = $this->getType($config->get('typeId'));
                $type->setConfig($config);
                if ($this->revision == true) {
                    $query = $type->joinRevision($query);
                } else {
                    $type->get($query);
                }
            } else {
                // is alter table
            }
        }
        return $query;
    }


    /**
     * Builder 에서 first()메소드 실행 시 join 처리
     *
     * @param DynamicQuery $query query builder
     * @return DynamicQuery
     */
    public function first(DynamicQuery $query)
    {
        /**
         * @var ConfigEntity $config
         */
        foreach ($this->getConfigs() as $config) {
            if ($this->isTableMethodCreate($config)) {
                $type = $this->getType($config->get('typeId'));
                $type->setConfig($config);
                if ($this->revision == true) {
                    $query = $type->joinRevision($query);
                } else {
                    $query = $type->first($query);
                }
            } else {
                // is alter table
            }
        }
        return $query;
    }

    /**
     * DynamicQuery 에서 ProxyManager 를 통해 실행
     * DynamicField 의 where 처리
     *
     * @param DynamicQuery $query  query builder
     * @param array        $wheres parameters for where
     * @return DynamicQuery
     */
    public function wheres(DynamicQuery $query, array $wheres)
    {
        /**
         * @var ConfigEntity $config
         */
        foreach ($this->getConfigs() as $config) {
            $type = $this->getType($config->get('typeId'));
            $type->setConfig($config);
            $query = $type->wheres($query, $wheres);
        }
        return $query;
    }

    /**
     * DynamicQuery 에서 ProxyManager 를 통해 실행
     * DynamicField 의 order 처리
     *
     * @param DynamicQuery $query  query builder
     * @param array        $orders parameters for where
     * @return DynamicQuery
     */
    public function orders(DynamicQuery $query, array $orders)
    {
        /**
         * @var ConfigEntity $config
         */
        foreach ($this->getConfigs() as $config) {
            $type = $this->getType($config->get('typeId'));
            $type->setConfig($config);
            $query = $type->orders($query, $orders);
        }
        return $query;
    }
}
