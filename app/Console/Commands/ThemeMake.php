<?php
/**
 * ThemeMake.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Console\Commands;

use Illuminate\Support\Fluent;

/**
 * Class ThemeMake
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ThemeMake extends ComponentMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:theme
                        {plugin : The plugin where the theme will be located}
                        {name : The name of theme to create}
                        
                        {--id= : The identifier of theme. default "<plugin>@<name>"}
                        {--path= : The path of theme. Enter the path to under the plugin. ex) SomeDir/ThemeDir}
                        {--class= : The class name of theme. default "<name>Theme"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new theme of XpressEngine';

    /**
     * The type of component.
     *
     * @var string
     */
    protected $componentType = 'theme';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Throwable
     */
    public function handle()
    {
        // get plugin info
        $plugin = $this->getPlugin();

        // get theme info
        $path = $this->getPath($this->option('path'));
        $namespace = $this->getNamespace($path);

        $className = $this->getClassName();
        $file = $this->getClassFile($path, $className);
        $id = $this->getThemeId();

        $title = $this->getTitleInput();
        $description = $this->getDescriptionInput();

        $attr = new Fluent(compact(
            'plugin',
            'path',
            'namespace',
            'className',
            'file',
            'id',
            'title',
            'description'
        ));

        // print and confirm the information of theme
        if($this->confirmInfo($attr) === false){
            return false;
        }

        $this->copyStubDirectory($plugin->getPath($path));

        try {
            $this->makeUsable($attr);
            $this->info('Generate the theme');

            // composer.json 파일 수정
            if ($this->registerComponent($plugin, $id, $namespace.'\\'.$className, $file, ['name' => $title, 'description' => $description]) === false) {
                throw new \Exception('Writing to composer.json file was failed.');
            }

            $this->refresh($plugin);
        } catch (\Exception $e) {
            $this->clean($path);
            throw $e;
        } catch (\Throwable $e) {
            $this->clean($path);
            throw $e;
        }

        $this->info("Theme is created successfully.");
    }

    /**
     * Get plugin name.
     *
     * @return string
     */
    protected function getPluginName()
    {
        return $this->argument('plugin');
    }

    /**
     * Get default path for component.
     *
     * @return string
     */
    protected function getDefaultPath()
    {
        return 'Themes/' . studly_case($this->argument('name'));
    }

    /**
     * Get class name.
     *
     * @return string
     */
    protected function getClassName()
    {
        return $this->option('class') ?: studly_case($this->argument('name')) . 'Theme';
    }

    /**
     * Get theme id.
     *
     * @return string
     * @throws \Exception
     */
    protected function getThemeId()
    {
        $id = $this->option('id');
        $plugin = $this->getPlugin();

        if(!$id) {
            $id = $plugin->getId().'@'.strtolower($this->argument('name'));
        } else {
            if(strpos('theme/', $id) === 0) {
                $id = substr($id, 6);
            }

            if(strpos($id, '@') === false) {
                $id = $plugin->getId().'@'.$id;
            }
        }

        $theme = app('xe.theme')->getTheme($id = 'theme/'.$id);

        if($theme !== null) {
            throw new \Exception("Theme[$id] already exists.");
        }

        return $id;
    }

    /**
     * Get component name.
     *
     * @return string
     */
    protected function getComponentName()
    {
        return $this->argument('name');
    }

    /**
     * Confirm information.
     *
     * @param Fluent|array $attr attributes
     * @return bool|null
     */
    protected function confirmInfo($attr)
    {
        $this->info(
            sprintf(
                "[New %s info]
  plugin:\t %s
  path:\t\t %s
  class file:\t %s
  class name:\t %s
  id:\t\t %s
  title:\t %s
  description:\t %s",
                $this->componentType,
                $attr['plugin']->getId(),
                $attr['path'],
                $attr['file'],
                $attr['namespace'].'\\'.$attr['className'],
                $attr['id'],
                $attr['title'],
                $attr['description']
              )
        );

        while ($confirm = $this->ask('Do you want to add theme? [yes|no]')) {
            if ($confirm === 'yes') {
                return true;
            } else {
                return false;
            }
        }

        return null;
    }

    /**
     * Make file for plugin by stub.
     *
     * @param Fluent|array $attr attributes
     * @return void
     * @throws \Exception
     */
    protected function makeUsable($attr)
    {
        $plugin = $attr['plugin'];
        $path = $plugin->getPath($attr['path']);

        $this->makeThemeClass($attr);

        rename($path.'/info.stub', $path.'/info.php');
        rename($path.'/views/gnb.blade.stub', $path.'/views/gnb.blade.php');
        rename($path.'/views/theme.blade.stub', $path.'/views/theme.blade.php');
    }

    /**
     * Make theme class.
     *
     * @param Fluent|array $attr attributes
     * @return void
     * @throws \Exception
     */
    protected function makeThemeClass($attr)
    {
        $plugin = $attr['plugin'];
        $path = $plugin->getPath($attr['path']);

        $search = ['DummyNamespace', 'DummyClass', 'DummyPluginId', 'DummyThemeDirname'];
        $replace = [$attr['namespace'], $attr['className'], $attr['plugin']->getId(), $attr['path']];

        $this->buildFile($path.'/theme.stub', $search, $replace, $plugin->getPath($attr['file']));
    }

    /**
     * Get stub path.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__.'/stubs/theme';
    }
}
