<?php
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
