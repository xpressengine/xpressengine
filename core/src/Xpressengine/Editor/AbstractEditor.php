<?php
/**
 *  AbstractEditor
 *
 * PHP version 5
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Editor;

use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Support\MobileSupportTrait;

/**
 * AbstractEditor
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class AbstractEditor implements ComponentInterface, Renderable
{
    use ComponentTrait;
    use MobileSupportTrait;

    protected $instanceId;

    protected static $configID = null;

    /**
     * @var ConfigEntity|null
     */
    protected $config;

    protected $arguments = [];

    /**
     * 에디터 이름 반환
     *
     * @return string
     */
    public static function getTitle()
    {
        return static::getComponentInfo('name');
    }

    /**
     * 에디터 설명 반환
     *
     * @return string
     */
    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

    /**
     * 에디터 스크린샷 반환
     *
     * @return mixed
     */
    public static function getScreenshot()
    {
        if (static::getComponentInfo('screenshot') === null) {
            return null;
        }
        return asset(static::getComponentInfo('screenshot'));
    }

    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;

        $this->config = $this->resolveConfig($instanceId);
    }

    protected static $resolver;

    public static function setConfigResolver(callable $resolver)
    {
        static::$resolver = $resolver;
    }

    protected function resolveConfig($instanceId)
    {
        if (!static::$resolver) {
            return null;
        }

        return call_user_func(static::$resolver, $this->getConfigKey($instanceId));
    }

    protected function getConfigKey($instanceId)
    {
        return $this->getId() . '.' . $instanceId;
    }




    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

//    /**
//     * 설정 등록
//     *
//     * @param string       $instanceId editor instance id
//     * @param ConfigEntity $config     config
//     * @return void
//     */
//    abstract public function setConfig($instanceId, ConfigEntity $config);
//
//    /**
//     * 설정 반환
//     *
//     * @param string $instanceId editor instance id
//     * @return mixed
//     */
//    abstract public function getConfig($instanceId);
//
//    /**
//     * 설정 삭제
//     *
//     * @param string $instanceId editor instance id
//     * @return void
//     */
//    abstract public function removeConfig($instanceId);

    /**
     * 에디터로 등록된 내용 출력
     *
     * @param string $contents contents
     * @return string
     */
    abstract public function contentsCompile($contents);

    /**
     * 에디터 관리자 폼 출력
     *
     * @param array $config editor config
     *
     * @return string|Renderable
     *
     * @deprecated 
     */
    public static function getSettingView($config = [])
    {
        return '';
    }

    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }
}
