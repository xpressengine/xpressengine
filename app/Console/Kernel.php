<?php
/**
 * Kernel.php
 *
 * PHP version 7
 *
 * @category    Console
 * @package     App\Console
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace App\Console;

use App\ResetProvidersTrait;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 *
 * @category    Console
 * @package     App\Console
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class Kernel extends ConsoleKernel
{
    use ResetProvidersTrait;

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \App\Bootstrappers\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\SetRequestForConsole::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\XeUpdate::class,
        Commands\Trash::class,
        Commands\TrashClean::class,
        Commands\Schema::class,
        Commands\TranslationImport::class,
        Commands\CacheClearPlus::class,
        Commands\StorageOptimize::class,
        Commands\Site::class,
        Commands\PluginMake::class,
        Commands\PluginInstall::class,
        Commands\PluginUpdate::class,
        Commands\PluginUninstall::class,
        Commands\PluginComposerSync::class,
        Commands\PrivateUpdateCommand::class,
        Commands\PluginPrivateInstall::class,
        Commands\ThemeMake::class,
        Commands\SkinMake::class,
        Commands\DynamicFieldMake::class,
        Commands\DynamicFieldSkinMake::class,
        Commands\CharsetConvert::class
    ];

    /**
     * If true, except xe services.
     *
     * @var bool
     */
    protected $skipXE = false;

    /**
     * The commands that need to off XE services.
     *
     * @var array
     */
    protected $skipXECommands = [
        'view:clear',
        'down',
        'up',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule Schedule instance
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

    /**
     * Run the console application.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input  input
     * @param \Symfony\Component\Console\Output\OutputInterface $output output
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
        return file_exists(app()->getInstalledPath());
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
     * Define commands for previously installation
     *
     * @return void
     */
    protected function setCommandBeforeInstall()
    {
        $this->commands = [Commands\XeInstall::class];
    }
}
