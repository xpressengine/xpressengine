<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
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
