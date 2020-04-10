<?php
/**
 * PluginComposerSync.php
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

use Illuminate\Console\Command;
use Xpressengine\Plugin\Composer\ComposerFileWriter;

/**
 * Class PluginComposerSync
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginComposerSync extends Command
{
    /**
     * The console command name.
     * php artisan plugin:sync-composer
     *
     * @var string
     */
    protected $signature = 'plugin:sync-composer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync plugins' composer.json with real plugin list";

    /**
     * Create a new controller creator command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ComposerFileWriter $writer ComposerFileWriter
     * @return void
     * @throws \Exception
     */
    public function handle(ComposerFileWriter $writer)
    {
        $writer->reset()->write();

        $this->output->success("The installation information of the plug-in was synchronized with the composer file(".$writer->getPath().").");
    }
}
