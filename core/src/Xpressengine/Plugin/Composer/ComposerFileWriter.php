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
    const STATUS_RUNNING   = 'running';
    const STATUS_SUCCESSED = 'successed';
    const STATUS_FAILED    = 'failed';
    const STATUS_EXPIRED   = 'expired';

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
     */
    public function __construct($path, PluginScanner $scanner)
    {
        require_once(__DIR__.'/helpers.php');
        $this->scanner = $scanner;
        $this->path = $path;
        $this->load();
    }

    /**
     * json 파일의 내용을 메모리에 읽어온다.
     *
     * @return void
     */
    public function load()
    {
        if (!is_file($this->path)) {
            $this->makeFile();
        }

        $str = file_get_contents($this->path);
        $this->data = json_decode($str, true);
    }

    /**
     * generate plugin composer file
     *
     * @return void
     */
    public function makeFile()
    {
        $data = [];

        $data['require'] = [];

        $data['xpressengine-plugin'] = [
            "path" => "storage/app/composer.plugins.json",
            "operation" => [],
        ];

        $this->data = $data;
        $this->write();
    }

    /**
     * 현재 설치된 플러그인들의 정보를 조회하여 반영한다.
     *
     * @return $this
     */
    public function reset()
    {
        // initialize
        $requires = [];
        $replace = [];

        $dir = $this->scanner->getPluginDirectory();
        $operation = '>=';

        foreach ($this->scanner->scanDirectory() as $plugin) {

            $name = array_get($plugin, 'metaData.name');
            $version = array_get($plugin, 'metaData.version');
            if (is_dir($dir.DIRECTORY_SEPARATOR.$plugin['id'].DIRECTORY_SEPARATOR.'vendor')) {
                $replace[$name] = '*';
                continue;
            }
            $requires[$name] = $operation.$version;
        }
        array_set($this->data, 'require', $requires);
        array_set($this->data, 'replace', $replace);

        // set fix mode
        $this->setFixMode();

        return $this;
    }

    /**
     * 현재 실행중인 작업에 대한 정보를 초기화 한다.
     *
     * @return $this
     */
    public function cleanOperation()
    {
        array_set($this->data, 'xpressengine-plugin.operation', []);
        return $this;
    }

    /**
     * setFixMode
     *
     * @return void
     */
    public function setFixMode()
    {
        $operation = '>=';
        $requires = [];
        foreach (array_get($this->data, 'require', []) as $package => $version) {
            $requires[$package] = str_replace($operation, '', $version);
        }
        array_set($this->data, 'require', $requires);
        array_set($this->data, 'xpressengine-plugin.mode', 'plugins-fixed');
    }

    /**
     * setUpdateMode
     *
     * @return void
     */
    public function setUpdateMode()
    {
        $operation = '>=';
        $requires = [];
        foreach (array_get($this->data, 'require', []) as $package => $version) {
            $requires[$package] = $operation.str_replace($operation, '', $version);
        }
        array_set($this->data, 'require', $requires);
        array_set($this->data, 'xpressengine-plugin.mode', 'plugins-update');
        array_set($this->data, "xpressengine-plugin.operation.status", ComposerFileWriter::STATUS_RUNNING);
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
     * register plugin to install list
     *
     * @param string $name        package name of plugin
     * @param string $version     plugin version
     * @param string $expiredTime deadline
     *
     * @return $this
     */
    public function install($name, $version, $expiredTime)
    {
        array_set($this->data, "xpressengine-plugin.operation.install.$name", $version);
        if ($expiredTime) {
            array_set($this->data, "xpressengine-plugin.operation.expiration_time", $expiredTime);
        } else {
            array_set($this->data, "xpressengine-plugin.operation.expiration_time", null);
        }

        $this->setUpdateMode();
        return $this;
    }

    /**
     * register plugin to update list
     *
     * @param string $name        package name of plugin
     * @param string $version     plugin version
     * @param string $expiredTime deadline
     *
     * @return $this
     */
    public function update($name, $version, $expiredTime)
    {
        array_set($this->data, "xpressengine-plugin.operation.update.$name", $version);
        array_set($this->data, "xpressengine-plugin.operation.expiration_time", $expiredTime);

        $this->setUpdateMode();
        return $this;
    }

    /**
     * register plugin to uninstall list
     *
     * @param string $name        package name of plugin
     * @param string $expiredTime deadline*
     *
     * @return $this
     */
    public function uninstall($name, $expiredTime)
    {
        $uninstall = array_get($this->data, "xpressengine-plugin.operation.uninstall", []);
        if (!in_array($name, $uninstall)) {
            $uninstall[] = $name;
        }
        array_set($this->data, "xpressengine-plugin.operation.uninstall", $uninstall);
        array_set($this->data, "xpressengine-plugin.operation.expiration_time", $expiredTime);

        $this->setUpdateMode();
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
