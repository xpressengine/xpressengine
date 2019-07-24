<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin\Sample;

use Xpressengine\Plugin\AbstractPlugin;

class PluginSample2 extends AbstractPlugin
{

    /**
     * @return boolean
     */
    public function install()
    {
        // TODO: Implement install() method.
    }

    /**
     * @return boolean
     */
    public function unInstall()
    {
        // TODO: Implement unInstall() method.
    }

    /**
     * @return boolean
     */
    public function checkInstalled()
    {
        // TODO: Implement checkInstall() method.
        return false;
    }

    /**
     * @return boolean
     */
    public function checkUpdated()
    {
        // TODO: Implement checkUpdate() method.
    }

    public function boot()
    {

    }


}
