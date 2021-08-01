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
use Illuminate\Support\Facades\Log;
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

    protected $scheduled_plugins = [];

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


    protected function registerPluginMethods(){
        // plugin list in site
        if(app()->getInstalledVersion() != null) {
            $configs = \DB::table('config')->where('name', 'plugin')->get();
            foreach ($configs as $config) {
                $vars = json_dec($config->vars, true);
                foreach ($vars['list'] as $id => $val) {
                    if ($val['status'] == 'activated') {
                        $entity = \XePlugin::getPlugin($id);
                        $pluginObj = $entity->getObject();

                        //register schedule method of plugin
                        //커맨드라인에서 URL없이 접속하기때문에, 사이트키 구분을 위해 해당 플러그인이 활성화된 사이트의 config에 붙어있는 site_key를 활용
                        if (method_exists($pluginObj, 'schedule')) {
                            if(array_get($this->scheduled_plugins,$config->site_key) == null) $this->scheduled_plugins[$config->site_key] = [];
                            $this->scheduled_plugins[$config->site_key][] = $pluginObj;
                        }

                        //register command class of plugin
                        //플러그인단에서 아티산커맨드를 활용할 수 있도록 등록은 해 주지만, 실제 사이트키 구분로직은 필요에 따라 내부에서 다시 구현해야함
                        if (method_exists($pluginObj, 'commandClass')) {
                            $command_class = $pluginObj->commandClass($config->site_key);
                            if(is_array($command_class)) {
                                foreach($command_class as $command) $this->commands[] = $command;
                            }else{
                                $this->commands[] = $pluginObj->commandClass($config->site_key);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule Schedule instance
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->registerPluginMethods();
        /**
        ** working with cron
        ** register crontab -e : * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
        **/
        foreach($this->scheduled_plugins as $site_key => $plugins){
            foreach($plugins as $pluginObj){
                try {
                    $pluginObj->schedule($schedule, $site_key);
                } catch (\Exception $e) {
                    Log::info(sprintf('Failed Schedule Working in %s site.\n%s:%s\n%s\n%s',$site_key,$e->getFile(),$e->getLine(),$e->getMessage(),$e->getCode()));
                    //see storage/logs/laravel-yyyy-mm-dd.log
                }
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->registerPluginMethods();
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
