<?php
/**
 * PrivateUpdateCommand.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Composer\Util\Filesystem;

/**
 * Class PrivateUpdateCommand
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PrivateUpdateCommand extends PluginCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'private:update {name : The name of the plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the private plugin.';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        if (!$plugin = $this->handler->getPlugin($name = $this->argument('name'))) {
            throw new \Exception("The plugin[$name] is not found.");
        }

        if (!$plugin->isPrivate()) {
            throw new \Exception("The plugin[$name] is not private plugin");
        }

        $this->startPrivate(function () use ($plugin, &$activated) {
            if ($activated = $plugin->isActivated()) {
                $this->deactivatePlugin($plugin->getId());
            }

            $this->info('Unlink plugin');
            $this->output->write('  - Unlinking ... ');
            // 윈도우와의 호환성을 위해 Composer FileSystem 유틸로 삭제 (Junction 삭제 지원)
            if (!app(Filesystem::class)->remove($plugin->getPath())) {
                throw new \RuntimeException('Unable to unlink.');
            }
            $this->info('done');

            $this->writeRequire('install', [
                ['name' => $packageName = 'xpressengine-plugin/'.$plugin->getId(), 'version' => '*']
            ]);

            $this->warn('Composer update command is running.. It may take up to a few minutes.');
            $this->line(" composer update --with-dependencies " . $packageName);

            $this->composerUpdate([$packageName]);

            // composer 실행을 마쳤습니다.
            $this->warn('Composer update command is finished.' . PHP_EOL);
        }, function () use ($plugin) {
            if (!is_link($plugin->getPath())) {
                app('files')->link(
                    app('path.privates').DIRECTORY_SEPARATOR.$plugin->getId(),
                    $plugin->getPath()
                );
            }
        });

        if ($activated) {
            $this->activatePlugin($name);
        }

        $this->output->success('Plugin is updated.');
    }
}
