<?php

/**
 * PluginMigrateReset.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Contributor - darron1217 <darron1217@gmail.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Console\Commands;

use Exception;
use Illuminate\Database\Console\Migrations\ResetCommand;

/**
 * Class PluginMigrateReset
 *
 * @category    Commands
 * @package     Xpressengine\Plugin\Migrations
 * @author      darron1217 (developers) <darron1217@gmail.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginMigrateReset extends ResetCommand
{
    use PluginMigrateTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback plugin\'s all database migrations';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $this->migrator->setConnection($this->option('database'));

        // First, we'll make sure that the migration table actually exists before we
        // start trying to rollback and re-run all the migrations. If it's not
        // present we'll just bail out with an info message for the developers.
        if ($this->migrator->repositoryExists() === false) {
            $this->comment('Migration table not found.');
        }

        $this->migrator->setOutput($this->output)->resetForPlugin(
            $this->getMigrationPaths(),
            $this->option('pretend'),
            $this->getFileList()
        );
    }
}