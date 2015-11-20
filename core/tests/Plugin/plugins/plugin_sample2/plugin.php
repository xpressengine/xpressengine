<?php
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
