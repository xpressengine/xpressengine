<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Plugin\Composer;

require_once(__DIR__.'/helpers.php');

use Xpressengine\Plugin\PluginScanner;

/**
 * plugin composer 파일을 제어하는 클래스.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ComposerFileWriter
{

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var PluginScanner
     */
    private $scanner;

    /**
     * @var string
     */
    private $packagistUrl;

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * ComposerFileWriter constructor.
     *
     * @param string        $path         path of plugin composer file
     * @param PluginScanner $scanner      plugin scanner
     * @param string        $packagistUrl packagist url
     */
    public function __construct($path, PluginScanner $scanner, $packagistUrl)
    {
        $this->scanner = $scanner;
        $this->path = $path;
        $this->reload();
        $this->packagistUrl = $packagistUrl;
    }

    /**
     * generate plugin composer file
     *
     * @return void
     */
    public function makeFile()
    {
        $data = [];
        $data['repositories'] = [];
        $data['repositories'][] = ['type' => 'composer', 'url' => $this->packagistUrl];

        $data['require'] = [];

        $data['xpressengine-plugin'] = [
            "path" => "storage/app/composer.plugins.json",
            "install" => [],
            "update" => [],
            "uninstall" => [],
            "changed" => []
        ];

        $this->data = $data;
        $this->write();
    }

    /**
     * reload plugin composer file
     *
     * @return void
     */
    public function reload()
    {
        if (!is_file($this->path)) {
            $this->makeFile();
        }

        $str = file_get_contents($this->path);
        $this->data = json_decode($str, true);
    }

    /**
     * register plugin to install list
     *
     * @param string $name    package name of plugin
     * @param string $version plugin version
     *
     * @return $this
     */
    public function install($name, $version)
    {
        array_set($this->data, "xpressengine-plugin.install.$name", $version);
        return $this;
    }

    /**
     * register plugin to update list
     *
     * @param string $name    package name of plugin
     * @param string $version plugin version
     *
     * @return $this
     */
    public function update($name, $version)
    {
        array_set($this->data, "xpressengine-plugin.update.$name", $version);
        return $this;
    }

    /**
     * register plugin to uninstall list
     *
     * @param string $name package name of plugin
     *
     * @return $this
     */
    public function uninstall($name)
    {
        $uninstall = array_get($this->data, "xpressengine-plugin.uninstall", []);
        if (!in_array($name, $uninstall)) {
            $uninstall[] = $name;
        }
        array_set($this->data, "xpressengine-plugin.uninstall", $uninstall);
        return $this;
    }

    /**
     * reset plugin install/update/uninstall list
     *
     * @return $this
     */
    public function reset()
    {
        array_set($this->data, "xpressengine-plugin.install", []);
        array_set($this->data, "xpressengine-plugin.update", []);
        array_set($this->data, "xpressengine-plugin.uninstall", []);
        return $this;
    }


    /**
     * add plugin to require
     *
     * @param string $name    package name of plugin
     * @param string $version version of plugin
     *
     * @return $this
     */
    public function addRequire($name, $version)
    {
        array_set($this->data, "require.$name", $version);
        return $this;
    }

    /**
     * remove plugin from require
     *
     * @param string $name package name of plugin
     *
     * @return $this
     */
    public function removeRequire($name)
    {
        array_forget($this->data, "require.$name");
        return $this;
    }

    /**
     * 현재 다운로드 되어 있는 플러그인 중에 require되어 있거나 vendor가 있는 플러그인을 제외한 플러그인의 composer.json 정보를 require시킨다.
     *
     * @return $this
     */
    public function resolvePlugins()
    {
        $requires = [];
        $replace = [];

        $dir = $this->scanner->getPluginDirectory();

        foreach ($this->scanner->scanDirectory() as $plugin) {

            $name = array_get($plugin, 'metaData.name');
            $version = array_get($plugin, 'metaData.version');
            if (is_dir($dir.DIRECTORY_SEPARATOR.$plugin['id'].DIRECTORY_SEPARATOR.'vendor')) {
                $replace[$name] = '*';
                continue;
            }
            $requires[$name] = $version;
        }
        array_set($this->data, 'require', $requires);
        array_set($this->data, 'replace', $replace);

        return $this;
    }

    /**
     * save loaded data to plugin composer file
     *
     * @return void
     */
    public function write()
    {
        $json = json_encode($this->data);
        if (function_exists('json_format')) {
            $json = json_format($json);
        } else {
            $json = \Composer\Json\JsonFormatter::format($json, true, true);
        }
        file_put_contents($this->path, $json);
    }

    /**
     * setUpdateMode
     *
     * @return $this
     */
    public function setUpdateMode()
    {
        $operation = '>=';
        $requires = [];
        foreach (array_get($this->data, 'require', []) as $package => $version) {
            $requires[$package] = $operation.str_replace($operation, '', $version);
        }
        array_set($this->data, 'require', $requires);

        array_set($this->data, 'repositories', [['type' => 'composer', 'url' => $this->packagistUrl]]);
        array_set($this->data, 'xpressengine-plugin.mode', 'plugins-update');
        array_set($this->data, 'xpressengine-plugin.changed', []);

        return $this;
    }

    /**
     * setFixMode
     *
     * @return $this
     */
    public function setFixMode()
    {
        $operation = '>=';
        $requires = [];
        foreach (array_get($this->data, 'require', []) as $package => $version) {
            $requires[$package] = str_replace($operation, '', $version);
        }
        array_set($this->data, 'require', $requires);

        array_set($this->data, 'repositories', [['type' => 'composer', 'url' => $this->packagistUrl]]);
        array_set($this->data, 'xpressengine-plugin.mode', 'plugins-fixed');

        $this->reset();

        return $this;
    }

    /**
     * retreive data
     *
     * @param string $key     data field key
     * @param mixed  $default default data
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    /**
     * set data
     *
     * @param string $key   data field key
     * @param mixed  $value data value
     *
     * @return void
     */
    public function set($key, $value)
    {
        array_set($this->data, $key, $value);
    }

    /**
     * get all data
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}
