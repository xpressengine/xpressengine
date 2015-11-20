<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Installation\InstallCommand;

class XeInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xe:install {--config= : Prepared file for configure}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xpressengine installation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $noInteract = $this->option('no-interaction');
        $config = $this->option('config');

        if ($noInteract === true && $config === null) {
            $noInteract = false;
        }

        $command = new InstallCommand($noInteract, $config);
        $command->setInstallPath(getcwd());
        $command->setApplication($this->getApplication());

        return $command->run($this->input, $this->output);
    }
}
