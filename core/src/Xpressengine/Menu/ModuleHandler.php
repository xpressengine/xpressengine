<?php
/**
 * Menu
 *
 * PHP version 7
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * @return array
     */
    public function getAllModuleInfo()
    {
        $modules = $this->getAll();

        $returnArr = [];

        foreach ($modules as $index => $module) {
            $returnArr[] = [
                'id' => $module::getId(),
                'title' => $module::getComponentInfo('name'),
                'description' => $module::getComponentInfo('description'),
                'screenshot' => $module::getComponentInfo('screenshot')
            ];
        }

        return $returnArr;
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
        $moduleId = full_module_id($moduleId);
        $moduleName = $this->register->get($moduleId);
        if ($moduleName === null) {
            throw new NotFoundModuleException;
        }
        $menuTypeObj = new $moduleName();
        return $menuTypeObj;
    }
}
