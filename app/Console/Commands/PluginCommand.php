<?php
/**
 * PluginCommand.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xpressengine\Foundation\Operator;
use Xpressengine\Installer\XpressengineInstaller;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

/**
 * Abstract Class PluginCommand
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class PluginCommand extends ShouldOperation
{
    use PluginApplyRequireTrait;

    /**
     * @var PluginHandler
     */
    protected $handler;

    /**
     * @var PluginProvider
     */
    protected $provider;

    /**
     * Constructor.
     *
     * @param Operator       $operator Operator
     * @param PluginHandler  $handler  PluginHandler
     * @param PluginProvider $provider PluginProvider
     */
    public function __construct(Operator $operator, PluginHandler $handler, PluginProvider $provider)
    {
        parent::__construct($operator);

        $this->handler = $handler;
        $this->provider = $provider;
    }

    /**
     * Run the console command.
     *
     * @param InputInterface  $input  input
     * @param OutputInterface $output output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->handler->getAllPlugins(true);

        return parent::run($input, $output);
    }

    /**
     * Initialize
     *
     * @param PluginHandler       $handler             PluginHandler
     * @param PluginProvider      $provider            PluginProvider
     * @param ComposerFileWriter  $writer              ComposerFileWriter
     * @param InterceptionHandler $interceptionHandler InterceptionHandler
     *
     * @deprecated since 3.0.1
     */
    protected function init(
        PluginHandler $handler,
        PluginProvider $provider,
        ComposerFileWriter $writer,
        InterceptionHandler $interceptionHandler
    ) {
        //
    }

    /**
     * Run cache clear.
     *
     * @return int
     *
     * @deprecated since 3.0.1
     */
    protected function clear()
    {
        return 0;
    }

    /**
     * Set a file for log.
     *
     * @param string $logFile log file path
     * @return void
     *
     * @deprecated
     */
    protected function setLogFile($logFile)
    {
    }

    /**
     * Write require to composer.plugins.json
     *
     * @param string $action keyword for action (install, update, uninstall)
     * @param array  $data   data for plugins
     * @return void
     */
    protected function writeRequire($action, $data)
    {
        foreach ($data as $info) {
            $this->operator->{$action}($info['name'], $info['version']);
        }
        $this->operator->save();
    }

    /**
     * Execute composer update.
     *
     * @param array $packages specific package name. no need version
     * @return void
     * @throws \Throwable
     */
    protected function composerUpdate(array $packages)
    {
        try {
            $this->applyRequire($this->operator->getOperation());

            $this->prepareComposer();

            $inputs = [
                'command' => 'update',
                "--with-dependencies" => true,
                '--working-dir' => base_path(),
                'packages' => $packages
            ];

            if (0 !== $result = $this->runComposer($inputs, false, $this->output)) {
                throw new \RuntimeException('Composer update failed..', $result);
            }
        } catch (\Exception $e) {
            $this->rollbackRequire();
            throw $e;
        } catch (\Throwable $e) {
            $this->rollbackRequire();
            throw $e;
        }

        $this->operator->setResult(XpressengineInstaller::$changed, XpressengineInstaller::$failed);
        $this->operator->save();
    }

    /**
     * Run composer dump command.
     *
     * @param string $path working directory
     * @return int
     * @throws \Exception
     */
    protected function composerDump($path)
    {
        $inputs = [
            'command' => 'dump-autoload',
            '--working-dir' => $path,
        ];

        return $this->runComposer($inputs, false, $this->output);
    }

    /**
     * Activate plugin.
     *
     * @param string $pluginId plugin id
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
     * Deactivate plugin.
     *
     * @param string $pluginId plugin id
     * @return void
     */
    protected function deactivatePlugin($pluginId)
    {
        $this->handler->getAllPlugins(true);
        if ($this->handler->isActivated($pluginId)) {
            $this->handler->deactivatePlugin($pluginId);
        }
    }

    /**
     * Update plugin.
     *
     * @param string $pluginId plugin id
     * @return void
     */
    protected function updatePlugin($pluginId)
    {
        $this->handler->getAllPlugins(true);
        $this->handler->updatePlugin($pluginId);
    }

    /**
     * Get changed.
     *
     * @return array
     */
    protected function getChangedPlugins()
    {
        return array_merge(['installed' => [], 'updated' => [], 'uninstalled' => []], $this->operator->getChanged());
    }

    /**
     * Get failed.
     *
     * @return array
     */
    protected function getFailedPlugins()
    {
        return array_merge(['install' => [], 'update' => [], 'uninstall' => []], $this->operator->getFailed());
    }

    /**
     * Print changed.
     *
     * @param array $changed changed information
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

    /**
     * Print failed.
     *
     * @return void
     */
    protected function printFailedPlugins()
    {
        $failed = $this->getFailedPlugins();

        $codes = [
            '401' => 'This is paid plugin. If you have already purchased this plugin, check the \'site_token\' field in your setting file(config/production/xe.php).',
            '403' => 'This is paid plugin. You need to buy it in the Market-place.',
        ];
        if (count($failed['install'])) {
            $this->warn('Install failed plugins:');
            foreach ($failed['install'] as $p => $c) {
                $this->line("  $p: ".($codes[$c] ?? $c));
            }
        }

        if (count($failed['update'])) {
            $this->warn('Update failed plugins:');
            foreach ($failed['update'] as $p => $c) {
                $this->line("  $p: ".($codes[$c] ?? $c));
            }
        }

        //if (count($failed['uninstall'])) {
        //    $this->warn('Uninstall failed plugins:');
        //    foreach ($failed['uninstall'] as $p => $c) {
        //        $this->line("  $p: ".$codes[$c]);
        //    }
        //}
    }

    /**
     * Parse plugin string.
     *
     * @param string $string name and version
     * @return array
     */
    protected function parse($string)
    {
        if (strpos($string, ':') === false) {
            return [$string, null];
        }

        return explode(':', $string, 2);
    }

    /**
     * Get plugin information.
     *
     * @param string      $id      plugin id
     * @param string|null $version version
     * @return array
     * @throws \Exception
     */
    protected function getPluginInfo($id, $version = null)
    {
        if (!$info = $this->provider->find($id)) {
            // 설치할 플러그인[$id]을 자료실에서 찾지 못했습니다.
            throw new \Exception("Can not find the plugin(".$id.") that should be installed from the Market-place.");
        }

        $title = $info->title;
        $name = $info->name;

        if ($version) {
            $releaseData = $this->provider->findRelease($id, $version);
            if ($releaseData === null) {
                // 플러그인[$id]의 버전[$version]을 자료실에서 찾지 못했습니다.
                throw new \Exception("Can not find version(".$version.") of the plugin(".$id.") that should be installed from the Market-place.");
            }
        }
        $version = $version ?: $info->latest_release->version;  // todo: 버전이 제공 되지 않았을땐 마지막 버전이 아니라 "*" 으로 ?

        return compact('id', 'name', 'version', 'title');
    }
}
