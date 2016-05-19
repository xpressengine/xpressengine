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

    protected static $resolver;

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

    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

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

    abstract public function getName();

    /**
     * 에디터로 등록된 내용 출력
     *
     * @param string $contents contents
     * @return string
     */
    abstract public function contentsCompile($contents);
    
    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }
}
