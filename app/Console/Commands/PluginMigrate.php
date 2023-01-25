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

use Illuminate\Database\Console\Migrations\MigrateCommand;

/**
 * Class PluginMigrate
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Contributor - darron1217 <darron1217@gmail.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginMigrate extends MigrateCommand
{
    use PluginMigrateTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:migrate {plugin : The name of the plugin}
                        {--database= : The database connection to use.}
                        {--force : Force the operation to run when in production}
                        {--path= : The path to the migrations files to be executed}
                        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
                        {--pretend : Dump the SQL queries that would be run}
                        {--seed : Indicates if the seed task should be re-run}
                        {--step : Force the migrations to be run so they can be rolled back individually}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run plugin\'s database migrations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->confirmToProceed() === false) {
            return;
        }

        $this->prepareDatabase();

        $options = [
            'pretend' => $this->option('pretend'),
            'step' => $this->option('step'),
        ];

        // Next, we will check to see if a path option has been defined. If it has
        // we will use the path relative to the root of this installation folder
        // so that migrations may be run for any path within the applications.
        $this->migrator->setOutput($this->output)->run(
            $this->getMigrationPaths(),
            $options
        );

        // Finally, if the "seed" option has been given, we will re-run the database
        // seed task to re-populate the database, which is convenient when adding
        // a migration and a seed at the same time, as it is only this command.
        if ($this->option('seed') === true && $this->option('pretend') === false) {
            $this->call('plugin:seed', ['plugin' => $this->argument('plugin'), '--force' => true]);
        }
    }
}