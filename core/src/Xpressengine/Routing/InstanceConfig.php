<?php
/**
 * Menu
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Routing;

use Xpressengine\Support\Singleton;

/**
 * InstanceConfig
 *
 * @category Menu
 * @package  Xpressengine\Menu
 */
class InstanceConfig extends Singleton
{

    /**
     * @var string $theme
     */
    public $theme;

    /**
     * @var string $instanceId
     */
    public $instanceId;

    /**
     * @var string $url
     */
    public $url;

    /**
     * @var string $module
     */
    public $module;

    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @return string
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * @param string $instanceId instance id
     *
     * @return void
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url url of instanceRoute
     *
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $theme theme of instanceRoute
     *
     * @return void
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param string $module module id
     *
     * @return void
     */
    public function setModule($module)
    {
        $this->module = $module;
    }
}
