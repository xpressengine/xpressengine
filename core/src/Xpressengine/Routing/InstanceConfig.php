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

namespace Xpressengine\Routing;

use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Support\Singleton;

/**
 * InstanceConfig
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */
class InstanceConfig extends Singleton
{

    /**
     * @var string $theme
     */
    private $theme;

    /**
     * @var string $instanceId
     */
    private $instanceId;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var string $module
     */
    private $module;

    /**
     * @var MenuItem $menuItem
     */
    private $menuItem;

    /**
     * Get theme component id
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set theme component id
     *
     * @param string $theme theme of instanceRoute
     * @return void
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get instance id
     *
     * @return string
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * Set instance id
     *
     * @param string $instanceId instance id
     * @return void
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;
    }

    /**
     * Get first url segment
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set first url segment
     *
     * @param string $url url of instanceRoute
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get module id
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set module id
     *
     * @param string $module module id
     * @return void
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * Get menu item instance
     *
     * @return MenuItem
     */
    public function getMenuItem()
    {
        return $this->menuItem;
    }

    /**
     * Set menu item instance
     *
     * @param MenuItem $item menu item instance
     * @return void
     */
    public function setMenuItem(MenuItem $item)
    {
        $this->menuItem = $item;
    }
}
