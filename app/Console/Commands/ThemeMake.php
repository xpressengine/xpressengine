<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Support\Fluent;

class ThemeMake extends ComponentMakeCommand
{
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
     * @var string
     */
    protected $componentType = 'theme';

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Exception
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

            // composer.json 파일 수정
            if ($this->registerComponent($plugin, $id, $namespace.'\\'.$className, $file, ['name' => $title, 'description' => $description]) === false) {
                throw new \Exception('Writing to composer.json file was failed.');
            }
            $this->runComposerDump($plugin->getPath());

        } catch (\Exception $e) {
            $this->clean($path);
            throw $e;
        }

        $this->info("Theme is created successfully.");
    }

    /**
     * get plugin name
     *
     * @return string
     */
    protected function getPluginName()
    {
        return $this->argument('plugin');
    }

    /**
     * get default path for component
     *
     * @return string
     */
    protected function getDefaultPath()
    {
        return 'Themes/' . studly_case($this->argument('name'));
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        return $this->option('class') ?: studly_case($this->argument('name')) . 'Theme';
    }

    /**
     * getThemeId
     *
     * @return array|string
     * @throws \Exception
     * @internal param $file
     *
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
     * get component name
     *
     * @return string
     */
    protected function getComponentName()
    {
        return $this->argument('name');
    }

    /**
     * confirmInfo
     *
     * @param Fluent|array $attr
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
     * @param Fluent|array $attr
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
     * makeThemeClass
     *
     * @param Fluent|array $attr
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
     * get stub path
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__.'/stubs/theme';
    }
}
