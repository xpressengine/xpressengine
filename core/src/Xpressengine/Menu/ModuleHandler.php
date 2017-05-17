<?php
/**
 * Menu
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Menu;

use Xpressengine\Menu\Exceptions\NotFoundModuleException;
use Xpressengine\Plugin\PluginRegister;

/**
 * Class ModuleHandler
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ModuleHandler
{
    /**
     * @var PluginRegister
     */
    protected $register;
    /**
     * @var string
     */
    protected $typeKey = 'module';

    /**
     * @param PluginRegister $register Xpressengine Register
     */
    public function __construct(PluginRegister $register)
    {
        $this->register = $register;
    }

    /**
     * getAll
     *
     * @return array
     */
    public function getAll()
    {
        return $this->register->get($this->typeKey);
    }

    /**
     * getAllModuleInfo
     *
     * @return \Generator
     */
    public function getAllModuleInfo()
    {
        $modules = $this->getAll();
        foreach ($modules as $index => $module) {
            yield [
                'id' => $module::getId(),
                'title' => $module::getComponentInfo('name'),
                'description' => $module::getComponentInfo('description'),
                'screenshot' => $module::getComponentInfo('screenshot')
            ];
        }
    }

    /**
     * getModuleClassName
     *
     * @param string $moduleId module id to find module class
     *
     * @return string|null
     */
    public function getModuleClassName($moduleId)
    {
        return $this->register->get($moduleId);
    }

    /**
     * getModuleObject
     *
     * @param string $moduleId module id to get module object
     *
     * @return mixed
     */
    public function getModuleObject($moduleId)
    {
        $moduleId = fullModuleId($moduleId);
        $moduleName = $this->register->get($moduleId);
        if ($moduleName === null) {
            throw new NotFoundModuleException;
        }
        $menuTypeObj = new $moduleName();
        return $menuTypeObj;
    }
}
