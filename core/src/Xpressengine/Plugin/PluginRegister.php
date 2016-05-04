<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Plugin;

use Xpressengine\Register\Container;

/**
 * Registrable 인터페이스를 따르는 요소를 등록합니다.
 * Theme, OIObject, Skin, DynamicField 등 Core 에서 특별히 취급하는 target 의 용어가 prefix 되어 있음
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
     * @var string
     */
    protected $pluginsDir;

    /**
     * PluginRegister constructor.
     *
     * @param Container $register Register
     */
    public function __construct(Container $register, $pluginsDir)
    {
        $this->register = $register;
        $this->pluginsDir = $pluginsDir;
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
            if ($class = array_get($info, 'class')) {
                $info['id'] = $id;
                $this->setComponentInfo($info);
                $this->add($class);
            } elseif ($path = array_get($info, 'path')) {
                // path가 있을 경우, path를 절대경로로 변환
                array_set($info, 'path', $this->pluginsDir.DIRECTORY_SEPARATOR.$entity->getId().DIRECTORY_SEPARATOR.$path);
                $this->register->set($id, $info);
                $parts = $this->split($id);
                $this->addByType($parts, $id, $info);
            }
        }
    }

    /**
     * register class
     * 플러그인의 composer.json 을 통해 등록하지 않을 때 사용
     *
     * @param ComponentInterface $component component class name
     *
     * @return void
     */
    public function add($component)
    {
        $id = $component::getId();
        $this->register->set($id, $component);

        $parts = $this->split($id);

        $this->addByType($parts, $id, $component);
    }

    /**
     * type, target + type 두가지 모두 등록
     *
     * @param array                    $parts     parts of id
     * @param string                   $id
     * @param array|ComponentInterface $component component class name
     *
     */
    protected function addByType(array $parts, $id, $component)
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
            default:
                if ($parts['target'] != '') {
                    $key = $target = $parts['target'].self::KEY_DELIMITER.$parts['type'];
                }
                $this->register->set($key.'.'.$id, $component);
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
     * @return string
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
     * @return string|array
     */
    protected function setComponentInfo(array $info)
    {
        $class = $info['class'];

        /** @var \Xpressengine\Plugin\ComponentInterface $class */
        if (!is_subclass_of($class, ComponentInterface::class)) {
            throw new Exceptions\NotImplementedException(['className' => $class]);
        }

        $class::setId($info['id']);
        $class::setComponentInfo(array_except($info, ['class', 'id']));
        return $class;
    }
}
