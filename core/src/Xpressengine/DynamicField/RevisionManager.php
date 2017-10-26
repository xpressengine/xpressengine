<?php
/**
 * RevisionManager
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

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;

/**
 * RevisionManager
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 * @deprecated  proxy option 으로 처리할 수 있도록 기능 수정
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
     * @param array        $configs config entity list
     * @param DynamicQuery $query   Illuminate query builder
     * @return DynamicQuery
     */
    public function join(array $configs, DynamicQuery $query)
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
