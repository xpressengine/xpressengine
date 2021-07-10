<?php

namespace App\Console\Commands;

use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

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
     * @param Filesystem $filesystem
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        // Parent's handle()
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->migrator->setConnection($this->option('database'));

        $this->migrator->rollback(
            $this->getMigrationPaths(), [
                'pretend' => $this->option('pretend'),
                'step' => (int) $this->option('step'),
                'file_list' => $this->getFileList(),
            ]
        );

        // Once the migrator has run we will grab the note output and send it out to
        // the console screen, since the migrator itself functions without having
        // any instances of the OutputInterface contract passed into the class.
        foreach ($this->migrator->getNotes() as $note) {
            $this->output->writeln($note);
        }

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

            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.'],

            ['step', null, InputOption::VALUE_OPTIONAL, 'The number of migrations to be reverted.'],
        ];
    }
}
