<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

	/**
	 * The bootstrap classes for the application.
	 *
	 * @var array
	 */
	protected $bootstrappers = [
			'Illuminate\Foundation\Bootstrap\DetectEnvironment',
			'App\Bootstrappers\LoadConfiguration',
			'Illuminate\Foundation\Bootstrap\ConfigureLogging',
			'Illuminate\Foundation\Bootstrap\HandleExceptions',
			'Illuminate\Foundation\Bootstrap\RegisterFacades',
			'Illuminate\Foundation\Bootstrap\SetRequestForConsole',
			'Illuminate\Foundation\Bootstrap\RegisterProviders',
			'Illuminate\Foundation\Bootstrap\BootProviders',
	];

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
        Commands\Inspire::class,
        Commands\XeInstall::class,
        Commands\XeUpdate::class,
        Commands\Trash::class,
        Commands\TrashClean::class,
        Commands\Schema::class,
        Commands\TranslationImport::class,
        Commands\CacheClear::class,
        Commands\StorageOptimize::class,
        Commands\Site::class,
        Commands\PluginMake::class,
        Commands\PluginInstall::class,
        Commands\PluginUpdate::class,
        Commands\PluginUninstall::class,
        Commands\PluginComposerSync::class,
        Commands\ThemeMake::class,
        Commands\SkinMake::class,
	];

    protected $skipXE = false;

    protected $skipXECommands = [
        'cache:clear',
        'view:clear',
        'down',
        'up',
    ];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')->hourly();
	}

    /**
     * Run the console application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function handle($input, $output = null)
    {
        $command = $input->getFirstArgument();
        if (in_array($command, $this->skipXECommands)) {
            $this->skipXE = true;
        }

        return parent::handle($input, $output);
    }

    /**
     * Bootstrap the application for artisan commands.
     *
     * @return void
     */
    public function bootstrap()
    {
        $args = func_get_args();
        $withXE = array_shift($args);

        if (!$this->isInstalled() && $withXE !== true) {
            $this->resetForFramework();
        } elseif ($this->skipXE !== false) {
            // without xe
            $this->resetForFramework();
        }else {
            $this->setCommandAfterInstall();
        }

        parent::bootstrap();
    }

    /**
     * check xe installed
     *
     * @return bool
     */
    protected function isInstalled()
    {
        return file_exists($this->app->storagePath() . '/app/installed');
    }

    /**
     * Redefine providers and command for framework activation.
     *
     * @return void
     */
    protected function resetForFramework()
    {
        $this->resetProviders();
        $this->setCommandBeforeInstall();
    }

    /**
     * Define for providers of framework.
     *
     * @return void
     */
    protected function resetProviders()
    {
        $this->app['events']->listen('bootstrapped: App\Bootstrappers\LoadConfiguration', function ($app) {
            $config = $app['config'];

            $providers = $config['app.providers'];
            $providers = array_filter($providers, function ($p) {
                return substr($p, 0, strlen('Illuminate')) == 'Illuminate';
            });

            $config->set('app.providers', $providers);
        });
    }

    /**
     * Define commands for previously installation
     *
     * @return void
     */
    protected function setCommandBeforeInstall()
    {
        $this->commands = array_intersect($this->commands, [
            Commands\Inspire::class,
            Commands\XeInstall::class
        ]);
    }

    /**
     * Define commands for after installation
     *
     * @return void
     */
    protected function setCommandAfterInstall()
    {
        $this->commands = array_diff($this->commands, [Commands\XeInstall::class]);
    }
}
