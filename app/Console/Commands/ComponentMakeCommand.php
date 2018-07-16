<?php
/**
 * MakeCommand.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use ReflectionClass;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\PluginEntity;

abstract class ComponentMakeCommand extends MakeCommand
{
    /**
     * @var \stdClass|null
     */
    protected $originComposerData = null;

    /**
     * @var string
     */
    protected $componentType;

    /**
     * Create a new component creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

        $this->addOption('--title', '', InputOption::VALUE_OPTIONAL, 'The title of component');
        $this->addOption('--description', '', InputOption::VALUE_OPTIONAL, 'The description of component');
    }

    /**
     * getTargetPlugin
     *
     * @return PluginEntity
     * @throws \Exception
     */
    protected function getPlugin()
    {
        if(!$plugin = app('xe.plugin')->getPlugin($name = $this->getPluginName())) {
            throw new \Exception("Unable to find a plugin to locate the skin file. plugin[$name] is not found.");
        }

        return $plugin;
    }

    /**
     * get plugin name
     *
     * @return string
     */
    abstract protected function getPluginName();

    /**
     * get path to be create
     *
     * @param string $path
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getPath($path = null)
    {
        if (!$path) {
            $path = $this->getDefaultPath();

            $autoload = $this->getOriginComposerData('autoload');
            $prefix = array_first((array)($autoload->{'psr-4'} ?? []));
            $path = $prefix ? rtrim($prefix,'/') . '/' . $path : $path;
        }

        return $path;
    }

    /**
     * get default path for component
     *
     * @return string
     */
    abstract protected function getDefaultPath();

    /**
     * @param string|null $key
     * @return mixed|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Exception
     */
    protected function getOriginComposerData($key = null)
    {
        if (!$this->originComposerData) {
            $composerStr = $this->files->get($this->getPlugin()->getPath('composer.json'));
            $this->originComposerData = json_decode($composerStr);
        }

        return $key ? data_get($this->originComposerData, $key) : $this->originComposerData;
    }

    /**
     * get namespace
     *
     * @param string $path
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function getNamespace($path)
    {
        $namespace = null;
        $autoload = $this->getOriginComposerData('autoload');
        foreach ((array)($autoload->{'psr-4'} ?? []) as $ns => $head) {
            if (starts_with($path, $head)) {
                $namespace = $ns;
                $path = substr($path, strlen($head));
                break;
            }
        }

        if (!$namespace) {
            $pluginClass = new ReflectionClass($this->getPlugin()->getClass());
            $namespace = $pluginClass->getNamespaceName();
        }

        $segments = array_map(function ($segment) {
            return studly_case($segment);
        }, explode('/', $path));

        return rtrim($namespace, '\\') . '\\' . implode('\\', $segments);
    }

    /**
     * get class file
     *
     * @param string $path
     * @param string $className
     * @return array|string
     * @throws \Exception
     */
    protected function getClassFile($path, $className)
    {
        $path = $path."/$className.php";
        if(file_exists($this->getPlugin()->getPath($path))) {
            throw new \Exception("file[$path] already exists.");
        }
        return $path;
    }

    /**
     * get title
     *
     * @return string
     */
    protected function getTitleInput()
    {
        return $this->option('title') ?: studly_case($this->getComponentName()) . ' ' . $this->componentType;
    }

    /**
     * get component name
     *
     * @return string
     */
    abstract protected function getComponentName();

    /**
     * get component description
     *
     * @return string
     * @throws \Exception
     */
    protected function getDescriptionInput()
    {
        if(!$description = $this->option('description')) {
            $description = 'The '.$this->componentType.' supported by '.ucfirst($this->getPlugin()->getId()).' plugin.';
        }
        return $description;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStubFile($filename)
    {
        return $this->getStubPath().'/'.$filename;
    }

    /**
     * register component
     *
     * @param PluginEntity $plugin
     * @param string $id
     * @param string $class
     * @param string $file
     * @param array $info
     * @return int
     * @throws \Exception
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function registerComponent(PluginEntity $plugin, $id, $class, $file, $info = [])
    {
        $data = unserialize(serialize($this->getOriginComposerData())); // clone
        $component = data_get($data, 'extra.xpressengine.component');
        if(isset($component->$id)) {
            throw new \Exception(sprintf('component[%s] already exists.', $id));
        }

        $component->$id = (object)array_merge($info, ['class' => $class]);
        data_set($data, 'extra.xpressengine.component', $component);

        if (!$this->existsAutoload($class, $file)) {
            // add autoload
            $classmap = data_get($data, 'autoload.classmap', []);
            $classmap[] = $file;
            data_set($data, 'autoload.classmap', $classmap);
        }

        return $this->files->put($plugin->getPath('composer.json'), json_format(json_encode($data)));
    }

    /**
     * determine if need to register autoload given class and file
     *
     * @param string $class
     * @param string $file
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function existsAutoload($class, $file)
    {
        $autoload = $this->getOriginComposerData('autoload');
        foreach ((array)($autoload->{'psr-4'} ?? []) as $ns => $head) {
            if (starts_with($file, $head) && starts_with($class, $ns)) {
                return true;
            }
        }

        return in_array($file, (array)($autoload->classmap ?? []));
    }

    /**
     * clean
     *
     * @param string $path
     * @return void
     * @throws \Exception
     */
    protected function clean($path)
    {
        $plugin = $this->getPlugin();

        // delete path
        if(is_writable($plugin->getPath($path))) {
            $this->files->deleteDirectory($plugin->getPath($path));
        }

        // unregister component from composer.json
        $composerFile = $plugin->getPath('composer.json');
        if($this->originComposerData !== null && is_writable($composerFile)) {
            $this->files->put($composerFile, json_format(json_encode($this->originComposerData)));
        }
    }
}
