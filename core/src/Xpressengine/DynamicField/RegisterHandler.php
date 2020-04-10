<?php
/**
 * RegisterHandler
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

use Xpressengine\DynamicField\DynamicFieldHandler as Handler;
use Xpressengine\Plugin\PluginRegister;
use Illuminate\Events\Dispatcher;

/**
 * RegisterHandler
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * create instance
     *
     * @param PluginRegister $register   register's container
     * @param Dispatcher     $dispatcher event dispatcher
     */
    public function __construct(PluginRegister $register, Dispatcher $dispatcher)
    {
        $this->register = $register;
        $this->dispatcher = $dispatcher;
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
        return new $class($handler, $this->dispatcher);
    }

    /**
     * container 에서 field type class name 반환.
     * AbstractType class instance
     *
     * @param Handler $handler dynamic field handler
     * @return array
     */
    public function getTypes(Handler $handler)
    {
        $returnArr = [];

        /** @var \Xpressengine\DynamicField\AbstractType $type */
        foreach ($this->register->get(self::FIELD_TYPE) as $type) {
            $returnArr[] =  $this->getType($handler, $type::getId());
        }

        return $returnArr;
    }

    /**
     * container 에서 field skin class name 반환.
     * AbstractSkin class instance
     *
     * @param Handler $handler dynamic field handler
     * @return array
     */
    public function getSkins(Handler $handler)
    {
        $returnArr = [];

        foreach ($this->register->get(self::FIELD_TYPE) as $id => $type) {
            /** @var \Xpressengine\DynamicField\AbstractSkin $skin */
            foreach ($this->register->get($id . PluginRegister::KEY_DELIMITER . self::FIELD_SKIN) as $skin) {
                $returnArr[] = $this->getType($handler, $skin::getId());
            }
        }

        return $returnArr;
    }

    /**
     * container 에서 field skin class name 반환.
     * AbstractSkin class instance
     *
     * @param Handler $handler dynamic field handler
     * @param string  $id      field type id
     * @return array
     */
    public function getSkinsByType(Handler $handler, $id)
    {
        $returnArr = [];

        /** @var \Xpressengine\DynamicField\AbstractSkin $skin */
        foreach ($this->register->get($id . PluginRegister::KEY_DELIMITER . self::FIELD_SKIN) as $skin) {
            $returnArr[] = $this->getSkin($handler, $skin::getId());
        }

        return $returnArr;
    }

    /**
     * get event dispatcher
     *
     * @return Dispatcher
     */
    public function getEventDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Fire an event and call the listeners.
     *
     * @param string|object $event   event
     * @param mixed         $payload payload
     * @param bool          $halt    stop event firing when response is not null
     * @return array|null
     */
    public function fireEvent($event, $payload = [], $halt = false)
    {
        // \Log::info($event);
        $this->dispatcher->fire($event, $payload, $halt);
    }
}
