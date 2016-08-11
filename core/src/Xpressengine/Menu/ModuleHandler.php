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
 * ModuleHandler
 * MenuItem 을 생성할 때 Module 을 관리하고 처리하는 역활
 * RouteInstance 와 밀접한 관계가 있으며 Plugin Module 이 대상이 된다
 *
 * ## app binding : xe.module 으로 바인딩 되어 있음
 * Module Facade 로 접근이 가능함.
 *
 * ## 사용법
 *
 * ### 전체 Module 조회
 * * Register 를 통해 모든 Module 들을 조회한다
 *
 * ```php
 * $allModules = $handler->getAll();
 * ```
 *
 * ### 전체 Module 의 정보 조회
 * * getAll()을 통해 조회된 내역들을 바탕으로 Module class 들의 정보를 조회
 *
 * ```php
 * $allModules = $handler->getAllModuleInfo();
 * ```
 *
 * ### ModuleClassName 조회
 * * Module Id 를 전달하여 ClassName 조회
 *
 * * 찾고자 하는 Module 의 Id 를 인자로 전달
 * ```php
 * $className = $menuHandler->getModuleClassName($moduleId);
 * ```
 *
 * ### ModuleClass 의 인스턴스화한 Object 획득
 * * Module Id(Module Id) 를 전달하여 인스턴스한 Object 를 획득
 *
 * * 찾고자 하는 Module 의 Id 를 인자로 전달
 * ```php
 * $moduleObject = $menuHandler->getModuleObject($moduleId);
 * ```
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
