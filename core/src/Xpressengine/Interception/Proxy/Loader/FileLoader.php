<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Interception\Proxy\Loader;

use Xpressengine\Interception\Proxy\Definition;
use Xpressengine\Interception\Proxy\ProxyConfig;

/**
 * 이 클래스는 동적으로 생성된 프록시 클래스를 파일로 생성후 로딩한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FileLoader implements Loader
{
    /**
     * @var string 동적으로 생성된 프록시 클래스 파일을 저장할 디렉토리 경로
     */
    private $path;

    /**
     * 이미 동일한 이름의 프록시 클래스 파일이 존재할 경우, 파일 시간을 비교하여 갱신할지의 여부
     * 만약 true이면 target 클래스 파일의 수정시간이 프록시 클래스 파일의 생성시간보다 오래됐을 경우 갱신한다.
     *
     * @var bool
     */
    private $checkFileTime;

    /**
     * constructor.
     *
     * @param string $path          디렉토리 경로
     * @param bool   $checkFileTime 파일시간의 비교 여부
     */
    public function __construct($path, $checkFileTime = false)
    {
        $this->path = $path;
        $this->checkFileTime = $checkFileTime;
    }

    /**
     * 주어진 프록시 클래스의 파일경로를 반환한다.
     *
     * @param string $proxyName 프록시 클래스명
     *
     * @return string
     */
    public function getProxyPath($proxyName)
    {
        return $this->path.'/'.$proxyName.'.php';
    }

    /**
     * 주어진 프록시 클래스에 해당하는 파일의 존재 여부를 조회한다.
     *
     * @param string $proxyName 프록시 클래스명
     *
     * @return bool
     */
    public function hasProxyFile($proxyName)
    {

        return file_exists($this->getProxyPath($proxyName));
    }

    /**
     * 주어진 프록시설정에 해당하는 클래스파일이 존재하는지 확인한다.
     * checkFileTime가 설정돼 있으면 파일시간을 체크하여 판단한다.
     *
     * @param ProxyConfig $config 프록시 설정
     *
     * @return bool 클래스파일이 존재할 경우 true를 반환한다.
     */
    public function existProxyFile(ProxyConfig $config)
    {
        if ($this->hasProxyFile($config->getProxyName()) === false) {
            return false;
        }

        if ($this->checkFileTime === false) {
            return true;
        }

        $targetPath = $config->getTargetPath();
        $proxyPath = $this->getProxyPath($config->getProxyName());
        if (filemtime($targetPath) < filemtime($proxyPath)) {
            return true;
        }

        \Log::debug('proxy is expired > '.$proxyPath);
        return false;
    }

    /**
     * 주어진 프록시 클래스 명세를 파일에 작성한 후 해당 클래스를 로드한다.
     *
     * @param Definition $definition 동적으로 생성할 프록시 클래스에 대한 명세
     *
     * @return void
     */
    public function load(Definition $definition)
    {
        if (class_exists($definition->getClassName(), false)) {
            return;
        }

        $path = $this->getProxyPath($definition->getClassName());

        @mkdir($this->path, 0777, true);
        file_put_contents($path, $definition->getCode());

        require_once($path);
    }

    /**
     * 기생성된 Proxy 파일을 모두 삭제한다.
     *
     * @return void
     */
    public function clear()
    {
        if (!file_exists($this->path)) {
            return;
        }

        $files = scandir($this->path);

        foreach ($files as $file) {
            if (strpos($file, '.') !== 0) {
                @unlink($this->path.'/'.$file);
            }
        }
    }
}
