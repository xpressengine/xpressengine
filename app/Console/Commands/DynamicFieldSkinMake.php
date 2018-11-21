<?php

namespace App\Console\Commands;


use Illuminate\Support\Fluent;

class DynamicFieldSkinMake extends ComponentMakeCommand
{
    protected $signature = 'make:fieldSkin
                        {plugin : The plugin where the skin will be located}
                        {name : The name of skin to create}
                        {dynamic_field_id : DynamicField id of this skin}
                        
                        {--id= : The identifier of skin. default "<plugin>@<name>"}
                        {--path= : The path of skin. Enter the path to under the plugin. ex) SomeDir/SkinDir}
                        {--class= : The class name of skin. default "<name>FieldSkin"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DynamicFieldSkin of XpressEngine';

    /**
     * @var string
     */
    protected $componentType = 'fieldSkin';

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

            // composer.json 파일 수정
            if ($this->registerComponent($plugin, $id, $namespace.'\\'.$className, $file, ['name' => $title, 'description' => $description]) === false) {
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
        return 'DynamicFieldSkins/' . studly_case($this->argument('name'));
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        return $this->option('class') ?: studly_case($this->argument('name'));
    }

    /**
     * getSkinId
     *
     * @return array|string
     * @throws \Exception
     * @internal param $file
     *
     */
    protected function getSkinId()
    {
        $id = $this->option('id');
        $plugin = $this->getPlugin();
        $targetDynamicField = $this->getSkinTarget();

        if (!$id) {
            $id = $plugin->getId().'@'.strtolower($this->argument('name'));
        } else {
            if (strpos('fieldSkin/', $id) === 0) {
                $id = substr($id, 10);
            }

            if (strpos($id, '@') === false) {
                $id = $plugin->getId().'@'.$id;
            }
        }

        if (!app('xe.dynamicField')->hasDynamicField($targetDynamicField)) {
            throw new \Exception("DynamicField[$targetDynamicField] doesn't exists.");
        }

        if (app('xe.dynamicField')->hasDynamicField($id = $targetDynamicField.'/fieldSkin/'.$id)) {
            throw new \Exception("DynamicFieldSkin[$id] already exists.");
        }

        return $id;
    }

    /**
     * get target
     *
     * @return string
     */
    protected function getSkinTarget()
    {
        return $this->argument('dynamic_field_id');
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

//        rename($path.'/views/create.blade.stub', $path.'/views/create.blade.php');
//        rename($path.'/views/edit.blade.stub', $path.'/views/edit.blade.php');
//        rename($path.'/views/search.blade.stub', $path.'/views/search.blade.php');
//        rename($path.'/views/settings.blade.stub', $path.'/views/settings.blade.php');
//        rename($path.'/views/show.blade.stub', $path.'/views/show.blade.php');
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
            str_replace('/', '.', $attr['path']),
            $attr['title'],
            $attr['description']];

        $this->buildFile($path.'/skin.stub', $search, $replace, $plugin->getPath($attr['file']));
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
        return __DIR__.'/stubs/dynamicFieldSkin';
    }
}
