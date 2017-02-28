<?php
/**
 * RegisterHandler
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

use Xpressengine\DynamicField\DynamicFieldHandler as Handler;
use Xpressengine\Plugin\PluginRegister;

/**
 * RegisterHandler
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class RegisterHandler
{
    const FIELD_TYPE = 'fieldType';
    const FIELD_SKIN = 'fieldSkin';

    /**
     * @var PluginRegister
     */
    protected $register;

    /**
     * create instance
     *
     * @param PluginRegister $register register's container
     */
    public function __construct(PluginRegister $register)
    {
        $this->register = $register;
    }

    /**
     * register dynamic field type class
     *
     * @param AbstractType $class class name of dynamic field type
     * @return void
     */
    public function add($class)
    {
        $this->register->add($class);
        $class::boot();
    }

    /**
     * get type
     *
     * @param Handler $handler dynamic field handler
     * @param string  $id      type id
     * @return AbstractType
     */
    public function getType(Handler $handler, $id)
    {
        $instance = $this->get($handler, $id);
        return $instance;
    }

    /**
     * get skin
     *
     * @param Handler $handler dynamic field handler
     * @param string  $id      skin id
     * @return AbstractSkin
     */
    public function getSkin(Handler $handler, $id)
    {
        $instance = $this->get($handler, $id);
        return $instance;
    }

    /**
     * get instance of field type or skin
     *
     * @param Handler $handler dynamic field handler
     * @param string  $id      field type id or skin id
     * @return AbstractType|AbstractSkin
     */
    protected function get(Handler $handler, $id)
    {
        $class = $this->register->get($id);
        return new $class($handler);
    }

    /**
     * container 에서 field type class name 반환.
     * AbstractType class instance
     *
     * @param Handler $handler dynamic field handler
     * @return \Generator
     */
    public function getTypes(Handler $handler)
    {
        /** @var \Xpressengine\DynamicField\AbstractType $type */
        foreach ($this->register->get(self::FIELD_TYPE) as $type) {
            yield $this->getType($handler, $type::getId());
        }
    }

    /**
     * container 에서 field skin class name 반환.
     * AbstractSkin class instance
     *
     * @param Handler $handler dynamic field handler
     * @return \Generator
     */
    public function getSkins(Handler $handler)
    {
        foreach ($this->register->get(self::FIELD_TYPE) as $id => $type) {
            /** @var \Xpressengine\DynamicField\AbstractSkin $skin */
            foreach ($this->register->get($id . PluginRegister::KEY_DELIMITER . self::FIELD_SKIN) as $skin) {
                yield $this->getType($handler, $skin::getId());
            }
        }
    }

    /**
     * container 에서 field skin class name 반환.
     * AbstractSkin class instance
     *
     * @param Handler $handler dynamic field handler
     * @param string  $id      field type id
     * @return \Generator
     */
    public function getSkinsByType(Handler $handler, $id)
    {
        /** @var \Xpressengine\DynamicField\AbstractSkin $skin */
        foreach ($this->register->get($id . PluginRegister::KEY_DELIMITER . self::FIELD_SKIN) as $skin) {
            yield $this->getSkin($handler, $skin::getId());
        }
    }
}
