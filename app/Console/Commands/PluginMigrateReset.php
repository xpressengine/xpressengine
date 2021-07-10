<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Filesystem\Filesystem;

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
     * handle 오버라이딩
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->migrator->setConnection($this->option('database'));

        // First, we'll make sure that the migration table actually exists before we
        // start trying to rollback and re-run all of the migrations. If it's not
        // present we'll just bail out with an info message for the developers.
        if (! $this->migrator->repositoryExists()) {
            return $this->comment('Migration table not found.');
        }

        $this->migrator->resetForPlugin(
            $this->getMigrationPaths(),
            $this->option('pretend'),
            $this->getFileList()
        );

        // Once the migrator has run we will grab the note output and send it out to
        // the console screen, since the migrator itself functions without having
        // any instances of the OutputInterface contract passed into the class.
        foreach ($this->migrator->getNotes() as $note) {
            $this->output->writeln($note);
        }
    }

}
