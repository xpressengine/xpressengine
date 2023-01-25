<?php

/**
 * PluginMigrateRollback.php
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
use Illuminate\Database\Console\Migrations\RollbackCommand;

/**
 * Class PluginMigrateRollback
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Contributor - darron1217 <darron1217@gmail.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginMigrateRollback extends RollbackCommand
{
    use PluginMigrateTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate:rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the plugin\'s last database migration';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        if ($this->confirmToProceed() === false) {
            return;
        }

        $options = [
            'pretend' => $this->option('pretend'),
            'step' => (int) $this->option('step'),
        ];

        $this->migrator->setConnection($this->option('database'));

        $this->migrator->setOutput($this->output)->rollbackForPlugin(
            $this->getMigrationPaths(), $options, $this->getFileList()
        );
    }
}