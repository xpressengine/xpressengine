<?php
/**
 * DynamicFieldMake.php
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
 * Class DynamicFieldMake
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class DynamicFieldMake extends ComponentMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:field
                        {plugin : The plugin where the skin will be located}
                        {name : The name of skin to create}
                        
                        {--id= : The identifier of skin. default "<plugin>@<name>"}
                        {--path= : The path of skin. Enter the path to under the plugin. ex) SomeDir/SkinDir}
                        {--class= : The class name of skin. default "<name>Field"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DynamicField of XpressEngine';

    /**
     * The type of component.
     *
     * @var string
     */
    protected $componentType = 'fieldType';

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Exception
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
        $id = $this->getFieldId();

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
            $this->info('Generate the dynamic field');

            $class = $namespace.'\\'.$className;

            $info = ['name' => $title, 'description' => $description];

            // composer.json 파일 수정
            if ($this->registerComponent($plugin, $id, $class, $file, $info) === false) {
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
        return 'DynamicFields/' . studly_case($this->argument('name'));
    }

    /**
     * Get class name.
     *
     * @return string
     */
    protected function getClassName()
    {
        return $this->option('class') ?: studly_case($this->argument('name')) . 'Field';
    }

    /**
     * Get dynamic field id
     *
     * @return array|string
     * @throws \Exception
     */
    protected function getFieldId()
    {
        $id = $this->option('id');
        $plugin = $this->getPlugin();

        if (!$id) {
            $id = $plugin->getId().'@'.strtolower($this->argument('name'));
        } else {
            if (strpos('fieldType/', $id) === 0) {
                $id = substr($id, 10);
            }

            if (strpos($id, '@') === false) {
                $id = $plugin->getId().'@'.$id;
            }
        }

        if (app('xe.dynamicField')->hasDynamicField($id = 'fieldType/'.$id)) {
            throw new \Exception("DynamicField[$id] already exists.");
        }

        return $id;
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
     * @param Fluent|array $attr
     * @return void
     * @throws \Exception
     */
    protected function makeUsable($attr)
    {
        $plugin = $attr['plugin'];
        $path = $plugin->getPath($attr['path']);

        $this->makeFieldClass($attr);

        rename($path.'/info.stub', $path.'/info.php');
        rename($path.'/views/setting.blade.stub', $path.'/views/setting.blade.php');
    }

    /**
     * Make dynamic field class.
     *
     * @param Fluent|array $attr attributes
     * @return void
     * @throws \Exception
     */
    protected function makeFieldClass($attr)
    {
        $plugin = $attr['plugin'];
        $path = $plugin->getPath($attr['path']);

        $search = [
            'DummyNamespace',
            'DummyClass',
            'DummyPluginId',
            'DummyFieldDirname',
            'DummyName',
            'DummyDescription'];
        $replace = [
            $attr['namespace'],
            $attr['className'],
            $attr['plugin']->getId(),
            $attr['path'],
            $attr['title'],
            $attr['description']];

        $this->buildFile($path.'/field.stub', $search, $replace, $plugin->getPath($attr['file']));
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
     * Get stub path.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__.'/stubs/dynamicField';
    }
}
