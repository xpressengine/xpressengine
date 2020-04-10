<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin\Sample;

use Xpressengine\Plugin\AbstractPlugin;

PluginSample2 extends AbstractPlugin
{

    /**
     * @return boolean
     */
    public function checkInstall($installedVersion = null)
    {
        // TODO: Implement checkInstall() method.
        return false;
    }

    public function boot()
    {

    }
}
