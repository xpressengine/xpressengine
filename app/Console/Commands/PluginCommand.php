<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

/**
 * @category
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginCommand extends Command
{
    use ComposerRunTrait;

    /**
     * @var PluginHandler
     */
    protected $handler;

    /**
     * @var PluginProvider
     */
    protected $provider;

    /**
     * @var ComposerFileWriter
     */
    protected $writer;

    protected function init(PluginHandler $handler, PluginProvider $provider, ComposerFileWriter $writer)
    {
        $this->handler = $handler;
        $this->provider = $provider;
        $this->writer = $writer;
    }

    /**
     * activatePlugin
     *
     * @param $pluginId
     *
     * @return void
     */
    protected function activatePlugin($pluginId)
    {
        $this->handler->getAllPlugins(true);
        if ($this->handler->isActivated($pluginId) === false) {
            $this->handler->activatePlugin($pluginId);

        }
    }

    /**
     * activatePlugin
     *
     * @param $pluginId
     *
     * @return void
     */
    protected function updatePlugin($pluginId)
    {
        $this->handler->getAllPlugins(true);
        $this->handler->updatePlugin($pluginId);
    }

    /**
     * getChanged
     *
     * @param ComposerFileWriter $writer
     *
     * @return array
     */
    protected function getChangedPlugins(ComposerFileWriter $writer)
    {
        $changed = [];
        $changed['installed'] = $writer->get('xpressengine-plugin.operation.changed.installed', []);
        $changed['updated'] = $writer->get('xpressengine-plugin.operation.changed.updated', []);
        $changed['uninstalled'] = $writer->get('xpressengine-plugin.operation.changed.uninstalled', []);
        return $changed;
    }


    /**
     * printChangedPlugins
     *
     * @param array $changed
     *
     * @return void
     */
    protected function printChangedPlugins(array $changed)
    {
        if (count($changed['installed'])) {
            $this->warn('Added plugins:');
            foreach ($changed['installed'] as $p => $v) {
                $this->line("  $p:$v");
            }
        }

        if (count($changed['updated'])) {
            $this->warn('Updated plugins:');
            foreach ($changed['updated'] as $p => $v) {
                $this->line("  $p:$v");
            }
        }

        if (count($changed['uninstalled'])) {
            $this->warn('Deleted plugins:');
            foreach ($changed['uninstalled'] as $p => $v) {
                $this->line("  $p:$v");
            }
        }
    }

}
