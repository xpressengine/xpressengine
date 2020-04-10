<?php
/**
 * ComponentMakeCommand.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use ReflectionClass;
use Symfony\Component\Console\Input\InputOption;
use Xpressengine\Foundation\Operator;
use Xpressengine\Plugin\PluginEntity;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

/**
 * Abstract Class ComponentMakeCommand
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
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
     * @param Filesystem         $files    Filesystem instance
     * @param Operator           $operator Operator instance
     * @param PluginHandler      $handler  PluginHandler instance
     * @param PluginProvider $provider PluginProvider instance
     */
    public function __construct(Filesystem $files, Operator $operator, PluginHandler $handler, PluginProvider $provider)
    {
        parent::__construct($files, $operator, $handler, $provider);

        $this->addOption('--title', '', InputOption::VALUE_OPTIONAL, 'The title of component');
        $this->addOption('--description', '', InputOption::VALUE_OPTIONAL, 'The description of component');
    }

    /**
     * GetTargetPlugin
     *
     * @return PluginEntity
     * @throws \Exception
     */
    protected function getPlugin()
    {
        if(!$plugin = $this->handler->getPlugin($name = $this->getPluginName())) {
            throw new \Exception("Unable to find a plugin to locate the skin file. plugin[$name] is not found.");
        }

        return $plugin;
    }

    /**
     * Get plugin name
     *
     * @return string
     */
    abstract protected function getPluginName();

    /**
     * Get path to be create
     *
     * @param string $path given path
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
     * Get default path for component
     *
     * @return string
     */
    abstract protected function getDefaultPath();

    /**
     * Get original composer data
     *
     * @param string|null $key key for data
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
     * Get namespace
     *
     * @param string $path given path
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
     * Get class file
     *
     * @param string $path      given path
     * @param string $className class name
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
     * Get title
     *
     * @return string
     */
    protected function getTitleInput()
    {
        return $this->option('title') ?: studly_case($this->getComponentName()) . ' ' . $this->componentType;
    }

    /**
     * Get component name
     *
     * @return string
     */
    abstract protected function getComponentName();

    /**
     * Get component description
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
     * Register component
     *
     * @param PluginEntity $plugin plugin entity
     * @param string       $id     component id
     * @param string       $class  class name
     * @param string       $file   class file path
     * @param array        $info   component information
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
     * Determine if need to register autoload given class and file
     *
     * @param string $class class name
     * @param string $file  class file path
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
     * Refresh the given plugin
     *
     * @param PluginEntity $plugin plugin entity
     * @return int
     * @throws \Exception
     */
    protected function refresh(PluginEntity $plugin)
    {
        $result = $this->composerDump($plugin->hasVendor() ? $plugin->getPath() : base_path());

        if (0 !== $result) {
            throw new \Exception('Fail to run composer dump');
        }

        return $result;
    }

    /**
     * Clean
     *
     * @param string $path path in plugin
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
