<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\Exceptions\CannotDeleteActivatedPluginException;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

class PluginUninstall extends PluginCommand
{
    /**
     * The console command name.
     * php artisan plugin:install [--without-activate] <plugin name> [<version>]
     * @var string
     */
    protected $signature = 'plugin:uninstall
                        {plugin_id : The plugin id for install}
                        {--deactivate : deactivate the plugin if plugin is activated.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall plugin of XpressEngine';

    /**
     * Execute the console command.
     *
     * @param PluginHandler      $handler
     * @param PluginProvider     $provider
     * @param ComposerFileWriter $writer
     *
     * @return bool|null
     * @throws \Exception
     */
    public function fire(PluginHandler $handler, PluginProvider $provider, ComposerFileWriter $writer)
    {
        $this->init($handler, $provider, $writer);

        // php artisan plugin:uninstall <plugin name>

        $id = $this->argument('plugin_id');

        // 플러그인이 설치돼 있는지 검사
        $plugin = $handler->getPlugin($id);
        if($plugin === null) {
            throw new \Exception('Is a plug-ins that have not been installed.');
        }

        if(file_exists($plugin->getPath('vendor'))) {
            throw new \Exception('It is a plug-in development mode. To remove a plug-in development mode, please delete the directory of direct plug-in.');
        }

        // 설치가능 환경인지 검사
        // - check writable of composer.plugin.json
        if(!is_writable($pluginDir = storage_path('app/composer.plugins.json'))) {
            throw new \Exception("[$pluginDir] You do not have write access to the file. To install the plug-in, you must have write permission of this file.");
        }

        // - check writable of plugins/ directory
        if(!is_writable($pluginDir = base_path('plugins'))) {
            throw new \Exception("[$pluginDir] You do not have write permissions to the directory. In order to install the plug-in, you must have write permissions for this directory.");
        }

        $title = $plugin->getTitle();
        $name = $plugin->getName();
        $version = $plugin->getVersion();

        // 플러그인 정보 출력
        $this->warn(PHP_EOL." Remove plug-in information:");
        $this->line("  $title - $name:$version".PHP_EOL);

        // 안내 멘트 출력
        $this->output->warning("Remove the above plug-ins. When you delete a plug-in, there are times when the site does not work properly.");
        if($this->input->isInteractive() && $this->confirm("Are you sure you want to remove the plug-in?") === false) {
            return;
        }

        if($this->option('deactivate')) {
            $handler->deactivatePlugin($id);
        }

        // 플러그인 uninstall 실행
        try {
            $handler->uninstallPlugin($id);
        } catch (CannotDeleteActivatedPluginException $e) {
            $e->setMessage('It is not possible to remove the active plug-ins. After you disable, or delete, please use the --deactivate option.');
            throw $e;
        }

        // - dependent plugins 갱신
        $writer->resolvePlugins();

        // - require에서 삭제할 플러그인 제거
        $writer->uninstall($name);

        $writer->write();

        $vendorName = PluginHandler::PLUGIN_VENDOR_NAME;

        // composer update실행(composer update --prefer-lowest --with-dependencies xpressengine-plugin/*)
        $this->warn('Run the composer update. There is a maximum moisture is applied.');
        $this->line(" composer update --prefer-lowest --with-dependencies $vendorName/$id");

        try {
            $result = $this->runComposer(base_path(), "update --prefer-lowest --with-dependencies $vendorName/$id");
        } catch (\Exception $e) {
            ;
        }

        $this->warn('The execution of the composer is now complete.'.PHP_EOL);

        // composer.plugins.json 파일을 다시 읽어들인다.
        $writer->reload();

        // changed plugin list 정보 출력
        $changed = $this->getChangedPlugins($writer);
        $this->printChangedPlugins($changed);

        if(array_has($changed, 'uninstalled.'.$name)) {
            // 삭제 성공 문구 출력
            $this->output->success("$title - $name:$version Plug-in uninstalled.");
        } else {
            $this->output->warning("Do not uninstall the plug-in of the $name:$version . Because of the dependencies between plug-ins, you may not be able to delete. Please check the plug-in dependencies.");
        }

    }

}
