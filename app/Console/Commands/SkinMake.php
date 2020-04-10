<?php
/**
 * SkinMake.php
 *
 * PHP version 7
 *
 * @category    Command
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Support\Fluent;

/**
 * Class SkinMake
 *
 * @category    Command
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SkinMake extends ComponentMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:skin
                        {plugin : The plugin where the skin will be located}
                        {name : The name of skin to create}
                        {target : The target id of this skin}
                        
                        {--id= : The identifier of skin. default "<plugin>@<name>"}
                        {--path= : The path of skin. Enter the path to under the plugin. ex) SomeDir/SkinDir}
                        {--class= : The class name of skin. default "<name>Skin"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new skin of XpressEngine';

    /**
     * The type of component
     *
     * @var string
     */
    protected $componentType = 'skin';

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Throwable
     */
    public function handle()
    {
        // get plugin info
        $plugin = $this->getPlugin();

        // get skin info
        $path = $this->getPath($this->option('path'));
        $namespace = $this->getNamespace($path);

        $className = $this->getClassName();
        $file = $this->getClassFile($path, $className);
        $id = $this->getSkinId();

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

        // print and confirm the information of skin
        if ($this->confirmInfo($attr) === false) {
            return false;
        }

        $this->copyStubDirectory($plugin->getPath($path));

        try {

            $this->makeUsable($attr);
            $this->info('Generate the skin');

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

        $this->info("Skin is created successfully.");
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
        return 'Skins/' . studly_case($this->argument('name'));
    }

    /**
     * Get class name.
     *
     * @return string
     */
    protected function getClassName()
    {
        return $this->option('class') ?: studly_case($this->argument('name')) . 'Skin';
    }

    /**
     * Get skin id.
     *
     * @return array|string
     * @throws \Exception
     */
    protected function getSkinId()
    {
        $id = $this->option('id');
        $plugin = $this->getPlugin();

        if(!$id) {
            $id = $plugin->getId().'@'.strtolower($this->argument('name'));
        } else {
            if(strpos('skin/', $id) === 0) {
                $id = substr($id, 5);
            }

            if(strpos($id, '@') === false) {
                $id = $plugin->getId().'@'.$id;
            }
        }

        $skin = app('xe.skin')->get($id = $this->getSkinTarget().'/skin/'.$id);

        if($skin !== null) {
            throw new \Exception("Skin[$id] already exists.");
        }

        return $id;
    }

    /**
     * Get target.
     *
     * @return string
     */
    protected function getSkinTarget()
    {
        return $this->argument('target');
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
     * Confirm information
     *
     * @param array $attr attributes
     * @return bool
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

        while ($confirm = $this->ask('Do you want to add skin? [yes|no]')) {
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
     * @param array $attr attributes
     * @return void
     * @throws \Exception
     */
    protected function makeUsable($attr)
    {
        $plugin = $attr['plugin'];
        $path = $plugin->getPath($attr['path']);

        $this->makeSkinClass($attr);

        rename($path.'/info.stub', $path.'/info.php');
        rename($path.'/views/index.blade.stub', $path.'/views/index.blade.php');
    }

    /**
     * Make skin class.
     *
     * @param array $attr attributes
     * @return void
     * @throws \Exception
     */
    protected function makeSkinClass($attr)
    {
        $plugin = $attr['plugin'];
        $path = $plugin->getPath($attr['path']);

        $search = ['DummyNamespace', 'DummyClass', 'DummyPluginId', 'DummySkinDirname'];
        $replace = [$attr['namespace'], $attr['className'], $attr['plugin']->getId(), $attr['path']];

        $this->buildFile($path.'/skin.stub', $search, $replace, $plugin->getPath($attr['file']));
    }

    /**
     * Get stub path.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__.'/stubs/skin';
    }
}
