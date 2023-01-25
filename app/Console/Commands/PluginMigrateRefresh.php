<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Database\Console\Migrations\RefreshCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class PluginComposerSync
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      darron1217 (developers) <darron1217@gmail.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginMigrateRefresh extends RefreshCommand
{
    use PluginMigrateTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset and re-run plugin\'s all migrations';

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

        $database = $this->input->getOption('database');

        $path = $this->getMigrationPath();
        $step = $this->input->getOption('step') ?: 0;

        if ($step > 0) {
            $this->runRollback($database, $path, $step);
        } else {
            $this->runReset($database, $path);
        }

        $this->call('plugin:migrate', [
            'plugin' => $this->argument('plugin'),
            '--database' => $database,
            '--force' => $this->option('force'),
        ]);

        if ($this->needsSeeding() === true) {
            $this->runSeeder($database);
        }
    }

    /**
     * Run the rollback command.
     *
     * @param  string  $database
     * @param  string  $path
     * @param  bool  $step
     * @return void
     */
    protected function runRollback($database, $path, $step)
    {
        $this->call('plugin:migrate:rollback', [
            'plugin' => $this->argument('plugin'),
            '--database' => $database,
            '--step' => $step,
            '--force' => $this->option('force'),
        ]);
    }

    /**
     * Run the reset command.
     *
     * @param  string  $database
     * @param  string  $path
     * @return void
     */
    protected function runReset($database, $path)
    {
        $this->call('plugin:migrate:reset', [
            'plugin' => $this->argument('plugin'),
            '--database' => $database,
            '--force' => $this->option('force'),
        ]);
    }

    /**
     * Run the database seeder command.
     *
     * @param  string  $database
     * @return void
     */
    protected function runSeeder($database)
    {
        $this->call('plugin:seed', [
            'plugin' => $this->argument('plugin'),
            '--database' => $database,
            '--class' => $this->option('seeder') ?: 'DatabaseSeeder',
            '--force' => $this->option('force'),
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],

            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],

            ['seed', null, InputOption::VALUE_NONE, 'Indicates if the seed task should be re-run.'],

            ['seeder', null, InputOption::VALUE_OPTIONAL, 'The class name of the root seeder.'],

            ['step', null, InputOption::VALUE_OPTIONAL, 'The number of migrations to be reverted & re-run.'],
        ];
    }
}