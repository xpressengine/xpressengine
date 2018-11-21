<?php

namespace App\Console\Commands;

use Illuminate\Support\Fluent;

class DynamicFieldMake extends ComponentMakeCommand
{
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
     * @var string
     */
    protected $componentType = 'fieldType';

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

            $class = $namespace.'\\'.$className;

            $info = ['name' => $title, 'description' => $description];

            // composer.json 파일 수정
            if ($this->registerComponent($plugin, $id, $class, $file, $info) === false) {
                throw new \Exception('Writing to composer.json file was failed.');
            }

            $this->runComposerDump($plugin->getPath());
        } catch (\Exception $e) {
            $this->clean($path);
            throw $e;
        }

        $this->info("Skin is created successfully.");
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
        return 'DynamicFields/' . studly_case($this->argument('name'));
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        return $this->option('class') ?: studly_case($this->argument('name')) . 'Field';
    }

    /**
     * getFieldId
     *
     * @return array|string
     * @throws \Exception
     * @internal param $file
     *
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
     * confirmInfo
     *
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
     * makeThemeClass
     *
     * @param Fluent|array $attr
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
     * get component name
     *
     * @return string
     */
    protected function getComponentName()
    {
        return $this->argument('name');
    }

    /**
     * get stub path
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__.'/stubs/dynamicField';
    }
}
