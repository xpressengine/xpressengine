<?php
/**
 * RevisionManager
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\DynamicField;

use Xpressengine\Config\ConfigEntity;
use \Illuminate\Database\Query\Builder;

/**
 * RevisionManager
 * > DynamicField 에서 revision 지원
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class RevisionManager
{

    /**
     * @var DynamicFieldHandler
     */
    protected $handler;

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
     * get dynamic field handler
     *
     * @return DynamicFieldHandler
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Revision 데이터 insert 처리 시 실행
     *
     * @param array $configs config entity list
     * @param array $args    insert data parameters
     * @return void
     */
    public function add(array $configs, array $args)
    {
        $register = $this->handler->getRegisterHandler();
        /**
         * @var ConfigEntity $config
         */
        foreach ($configs as $config) {
            $type = $register->getType($this->handler, $config->get('typeId'));
            $type->setConfig($config);
            $type->insertRevision($args);
        }
    }

    /**
     * make join query for revision
     *
     * @param array   $configs config entity list
     * @param Builder $query   Illuminate query builder
     * @return Builder
     */
    public function join(array $configs, Builder $query)
    {
        $register = $this->handler->getRegisterHandler();
        /**
         * @var ConfigEntity $config
         */
        foreach ($configs as $config) {
            $type = $register->getType($this->handler, $config->get('typeId'));
            $type->setConfig($config);
            $query = $type->joinRevision($query);
        }

        return $query;
    }
}
