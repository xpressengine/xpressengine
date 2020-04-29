<?php
/**
 * PluginOperation.php
 *
 * PHP version 7
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Foundation\Operations;

/**
 * Class PluginOperation
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PluginOperation extends Operation
{
    /**
     * Set the plugin to the install item.
     *
     * @param string $name    plugin name
     * @param string $version version
     * @return $this
     */
    public function install($name, $version)
    {
        $this->data['todo']['install'][$name] = $version;

        return $this;
    }

    /**
     * Get the install items.
     *
     * @return array
     */
    public function getInstall()
    {
        return $this->data['todo']['install'] ?? [];
    }

    /**
     * Set the plugin to the update item.
     *
     * @param string $name    plugin name
     * @param string $version version
     * @return $this
     */
    public function update($name, $version)
    {
        $this->data['todo']['update'][$name] = $version;

        return $this;
    }

    /**
     * Get the update items.
     *
     * @return array
     */
    public function getUpdate()
    {
        return $this->data['todo']['update'] ?? [];
    }

    /**
     * Set the plugin to the uninstall item.
     *
     * @param string $name plugin name
     * @return $this
     */
    public function uninstall($name)
    {
        $items = $this->getUninstall();
        if (!in_array($name, $items)) {
            $items[] = $name;
        }
        $this->data['todo']['uninstall'] = $items;

        return $this;
    }

    /**
     * Get the uninstall items.
     *
     * @return array
     */
    public function getUninstall()
    {
        return $this->data['todo']['uninstall'] ?? [];
    }

    /**
     * Flush the operation items.
     *
     * @return $this
     */
    public function flush()
    {
        if (isset($this->data['todo'])) {
            unset($this->data['todo']);
        }
        if (isset($this->data['changed'])) {
            unset($this->data['changed']);
        }
        if (isset($this->data['failed'])) {
            unset($this->data['failed']);
        }

        return $this;
    }

    /**
     * Set the result information.
     *
     * @param array $changed changed list
     * @param array $failed  failed list
     * @return $this
     */
    public function setResult(array $changed, array $failed)
    {
        $this->data['changed'] = $changed;
        $this->data['failed'] = $failed;

        return $this;
    }

    /**
     * Get the changed items.
     *
     * @return array
     */
    public function getChanged()
    {
        return $this->data['changed'] ?? [];
    }

    /**
     * Get the failed items.
     *
     * @return array
     */
    public function getFailed()
    {
        return $this->data['failed'] ?? [];
    }
}
