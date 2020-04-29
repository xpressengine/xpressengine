<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ComposerFileWriter
{
    /**
     * @deprecated since 3.0.1, use \Xpressengine\Foundation\Operations\Operation
     */
    const STATUS_READY     = 'ready';
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
     * @var array
     */
    protected $original;

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
     * @param string        $path    path of plugin composer file
     * @param PluginScanner $scanner plugin scanner
     */
    public function __construct($path, PluginScanner $scanner)
    {
        require_once(__DIR__.'/helpers.php');
        $this->scanner = $scanner;
        $this->path = $path;
        $this->load(true);
    }

    /**
     * json 파일의 내용을 메모리에 읽어온다.
     *
     * @param bool $sync sync to original if given value is true
     * @return void
     */
    public function load($sync = false)
    {
        if (!is_file($this->path)) {
            $this->data = [];
        } else {
            $str = file_get_contents($this->path);
            $this->data = json_decode($str, true);
        }

        if ($sync) {
            $this->sync();
        }
    }

    /**
     * Sync the original data with the current.
     *
     * @return $this
     */
    public function sync()
    {
        $this->original = $this->data;

        return $this;
    }

    /**
     * Rollback the data from the original.
     *
     * @return void
     */
    public function rollback()
    {
        $this->data = $this->original;

        $this->write();
    }

    /**
     * generate plugin composer file
     *
     * @return void
     *
     * @deprecated since 3.0.1
     */
    public function makeFile()
    {
        $data = [];

        $data['require'] = [];

        $data['xpressengine-plugin'] = [
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
        $requires = [];
        $replace = [];

        $dir = $this->scanner->getPluginDirectory();

        foreach ($this->scanner->scanDirectory() as $plugin) {
            $name = array_get($plugin, 'metaData.name');
            $version = array_get($plugin, 'metaData.version');
            if (is_dir($dir.DIRECTORY_SEPARATOR.$plugin['id'].DIRECTORY_SEPARATOR.'vendor')) {
                $replace[$name] = '*';
                continue;
//            } elseif (is_link($dir.DIRECTORY_SEPARATOR.$plugin['id'])) {
//                continue;
            }
            $requires[$name] = $version;
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
     * @deprecated since 3.0.1
     */
    public function cleanOperation()
    {
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
    }

    /**
     * setUpdateMode
     *
     * @param array $fixedList the list of version fixed plugins
     *
     * @return void
     */
    public function setUpdateMode($fixedList = [])
    {
        $operation = '>=';
        $requires = [];
        foreach (array_get($this->data, 'require', []) as $package => $version) {
            if (empty($fixedList) || in_array($package, $fixedList)) {
                $requires[$package] = str_replace($operation, '', $version);
            } else {
                $requires[$package] = $operation.str_replace($operation, '', $version);
            }
        }
        array_set($this->data, 'require', $requires);
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
     * @deprecated since 3.0.1
     */
    public function install($name, $version, $expiredTime = null)
    {
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
     * @deprecated since 3.0.1
     */
    public function update($name, $version, $expiredTime = null)
    {
        return $this;
    }

    /**
     * register plugin to uninstall list
     *
     * @param string $name        package name of plugin
     * @param string $expiredTime deadline (deprecated since 3.0.1)
     *
     * @return $this
     * @eprecated since 3.0.1
     */
    public function uninstall($name, $expiredTime = null)
    {
        return $this;
    }

    /**
     * save loaded data to plugin composer file
     *
     * @param bool $sync sync to original if given value is true
     * @return void
     */
    public function write($sync = false)
    {
        $json = json_encode($this->data);
        if (function_exists('json_format')) {
            $json = json_format($json);
        } else {
            $json = \Composer\Json\JsonFormatter::format($json, true, true);
        }
        file_put_contents($this->path, $json);

        if ($sync) {
            $this->sync();
        }
    }

    /**
     * retrieve data
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
