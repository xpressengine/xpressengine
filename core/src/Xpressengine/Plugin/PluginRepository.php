<?php
/**
 * PluginRepository.php
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

use Illuminate\Filesystem\Filesystem;

/**
 * Class PluginRepository
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PluginRepository
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The plugin scanner instance.
     *
     * @var PluginScanner
     */
    protected $scanner;

    /**
     * The manifest path.
     *
     * @var string|null
     */
    protected $manifestPath;

    /**
     * The loaded manifest array.
     *
     * @var array
     */
    protected $manifest;

    /**
     * The class for plugin entity.
     *
     * @var string
     */
    protected $entityClass;

    /**
     * PluginRepository constructor.
     *
     * @param Filesystem    $files        The filesystem instance.
     * @param PluginScanner $scanner      The plugin scanner instance.
     * @param string        $manifestPath The manifest path.
     * @param string        $entity       The class for plugin entity.
     */
    public function __construct(Filesystem $files, PluginScanner $scanner, $manifestPath, $entity = PluginEntity::class)
    {
        $this->files = $files;
        $this->scanner = $scanner;
        $this->manifestPath = $manifestPath;
        $this->entityClass = $entity;
    }

    /**
     * Register the xpressengine plugins.
     *
     * @param bool $force re-build the manifest
     * @return array
     */
    public function load($force = false)
    {
        if ($force || $this->manifest === null) {
            $this->loadManifest($force);
        }

        return $this->manifest;
    }

    /**
     * Load the plugin provider manifest JSON file and class.
     *
     * @param bool $force re-build the manifest
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function loadManifest($force)
    {
        if ($force || !file_exists($this->manifestPath)) {
            $this->build();
        }

        foreach ($this->files->getRequire($this->manifestPath) as $id => $item) {
            $this->manifest[$id] = $this->createEntity($id, $item['path'], $item['class'], $item['metaData']);
        }
    }

    /**
     * Build the manifest and write it to disk.
     *
     * @return void
     */
    protected function build()
    {
        $data = $this->scanner->scanDirectory();
        $manifest = [];
        foreach ($data as $id => $info) {
            $manifest[$id] = [
                'class' => $info['class'],
                'path' => $info['path'],
                'metaData' => $info['metaData'],
            ];
        }
        $this->write($manifest);
    }

    /**
     * Write the given manifest array to disk.
     *
     * @param array $manifest manifest array
     * @return void
     * @throws \Exception
     */
    protected function write($manifest)
    {
        if (!is_writable(dirname($this->manifestPath))) {
            throw new \Exception(
                'The '.dirname($this->manifestPath).' directory must be present and writable.'
            );
        }

        $this->files->put($this->manifestPath, '<?php return '.var_export($manifest, true).';');
    }

    /**
     * Create a new instance of the plugin.
     *
     * @param string $id    plugin id
     * @param string $path  the path of plugin.php
     * @param string $class the class name of plugin.php
     * @param array  $meta  the meta data for plugin
     * @return PluginEntity
     */
    protected function createEntity($id, $path, $class, array $meta)
    {
        return new $this->entityClass($id, $path, $class, $meta);
    }
}
