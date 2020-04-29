<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

use Xpressengine\Plugin\Exceptions\ComponentNotFoundException;
use Xpressengine\Plugin\Exceptions\NotImplementedException;
use Xpressengine\Register\Container;

/**
 * Registrable 인터페이스를 따르는 요소를 등록합니다.
 * Theme, OIObject, Skin, DynamicField 등 Core 에서 특별히 취급하는 target 의 용어가 prefix 되어 있음
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PluginRegister
{

    /**
     * 등록 아이디에서 등록 플러그인과 고유 아이디를 구분하는 구분자
     */
    const NAME_DELIMITER = '@';

    /**
     * key delimiter
     */
    const KEY_DELIMITER = '/';

    /**
     * register container
     *
     * @var Container
     */
    protected $register;


    /**
     * unresolved entity list
     *
     * @var array
     */
    protected $unresolvedComponents = [];


    /**
     * PluginRegister constructor.
     *
     * @param Container $register Register
     */
    public function __construct(Container $register)
    {
        $this->register = $register;
    }

    /**
     * get Unresolved Components
     *
     * @return array component info
     */
    public function getUnresolvedComponents()
    {
        return $this->unresolvedComponents;
    }

    /**
     * 주어진 플러그인에 포함된 component를 register에 등록한다.
     *
     * @param PluginEntity $entity 플러그인
     *
     * @return void
     */
    public function addByEntity(PluginEntity $entity)
    {
        $componentList = $entity->getComponentList();

        foreach ($componentList as $id => $info) {
            $info['id'] = $id;
            $info['plugin'] = $entity;
            try {
                $this->setComponentInfo($info);
                $this->add($info['class']);
            } catch (ComponentNotFoundException $e) {
                array_set($this->unresolvedComponents[$entity->getId()], $id, $info);
            } catch (NotImplementedException $e) {
                $this->unresolvedComponents[$entity->getId()] = $info;
            }
        }
    }



    /**
     * register class
     * 플러그인의 composer.json 을 통해 등록하지 않을 때 사용
     *
     * @param string $component component class name
     *
     * @return void
     */
    public function add($component)
    {
        /** @var ComponentInterface $component */
        $id = $component::getId();
        $this->register->set($id, $component);

        $parts = $this->split($id);

        $this->addByType($parts, $component);
    }

    /**
     * type, target + type 두가지 모두 등록
     *
     * @param array              $parts     parts of id
     * @param ComponentInterface $component component class name
     *
     * @return void
     */
    protected function addByType(array $parts, $component)
    {
        $key = $parts['type'];

        switch ($key) {
            case 'module':
            case 'skin':
            case 'settingsSkin':
            case 'theme':
            case 'settingsTheme':
            case 'widget':
            case 'uiobject':
            case 'FieldType':
            case 'FieldSkin':
            case 'editor':
            default:
                if ($parts['target'] != '') {
                    $key = $target = $parts['target'].self::KEY_DELIMITER.$parts['type'];
                }
                $this->register->set($key.'.'.$component::getId(), $component);
                break;
        }
    }

    /**
     * get Registrable class name
     *
     * @param string $id component's id
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->register->get($id);
    }

    /**
     * 주어진 id를 name, plugin, type, target로 구분한다.
     *
     * @param string $id component id
     *
     * @return array
     */
    protected function split($id)
    {
        $parts = explode(self::NAME_DELIMITER, $id);
        if (count($parts) < 2) {
            throw new Exceptions\InvalidComponentIdException(['error' => '"name" not found.']);
        }
        $name = $parts[count($parts) - 1];

        $parts = explode(self::KEY_DELIMITER, substr($id, 0, strrpos($id, self::NAME_DELIMITER.$name)));
        $plugin = null;
        if (count($parts) === 1) {
            $type = $parts[0];
        } else {
            $plugin = $parts[count($parts) - 1];
            $type = $parts[count($parts) - 2];
        }

        if ($type === false) {
            throw new Exceptions\InvalidComponentIdException(['error' => '"type" not found.']);
        }

        $target = '';
        if ($plugin !== null) {
            $target = substr(
                $id,
                0,
                strrpos($id, self::KEY_DELIMITER.$type.self::KEY_DELIMITER.$plugin.self::NAME_DELIMITER.$name)
            );
        }

        return compact('name', 'plugin', 'type', 'target');
    }

    /**
     * 주어진 정보를 component에 설정한다.
     *
     * @param array $info component 정보
     *
     * @return void
     */
    protected function setComponentInfo(array $info)
    {
        /** @var \Xpressengine\Plugin\ComponentInterface $class */
        $class = $info['class'];

        if (!class_exists($class)) {
            throw new ComponentNotFoundException(['className' => $class, 'pluginId' => $info['plugin']->getId()]);
        }
        if (!is_subclass_of($class, ComponentInterface::class)) {
            throw new NotImplementedException(['className' => $class]);
        }

        $class::setId($info['id']);

        $class::setComponentInfo(array_except($info, ['class', 'id']));
    }
}
