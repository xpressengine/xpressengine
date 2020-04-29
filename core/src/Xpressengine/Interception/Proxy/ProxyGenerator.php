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

namespace Xpressengine\Interception\Proxy;

use Xpressengine\Interception\Proxy\Loader\FileLoader;
use Xpressengine\Interception\Proxy\Loader\Loader;
use Xpressengine\Interception\Proxy\Pass\Pass;

/**
 * 타겟 클래스에 Interception를 적용하기 위하여 필요한 프록시 클래스를 생성하고, 로드한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ProxyGenerator
{
    /**
     * @var Loader 프록시클래스 로더. 프록시 클래스를 동적으로 생성한 다음 로더를 사용하여 로드한다.
     */
    protected $loader;

    /**
     * @var Pass[] 프록시 클래스의 코드를 생성할 때 사용되는 Pass 목록
     */
    protected $passes;

    /**
     * constructor.
     *
     * @param Loader $loader 프록시클래스 로더
     * @param Pass[] $passes Pass 목록
     */
    public function __construct(Loader $loader, array $passes)
    {
        $this->loader = $loader;
        $this->passes = $passes;
    }

    /**
     * 기생성된 Proxy 파일을 모두 삭제한다.
     *
     * @return void
     */
    public function clear()
    {
        if ($this->loader instanceof FileLoader) {
            $this->loader->clear();
        }
    }

    /**
     * 주어진 타겟 클래스의 프록시 클래스를 생성하고, 로드한 다음 프록시 클래스명을 반환한다.
     * 비지니스 로직에서는 타겟 클래스 대신 프록시 클래스의 인스턴스를 생성하여 사용한다.
     *
     * @param string $targetClass 프록시 클래스를 생성할 타겟 클래스
     *
     * @return string
     */
    public function generate($targetClass)
    {
        $config = new ProxyConfig($targetClass);

        // 파일 로더일 경우, 성능향상을 위하여 프록시 클래스 파일이 존재할 경우,
        // 생성 과정을 거치지 않고 바로 클래스명을 반환한다.
        if ($this->loader instanceof FileLoader) {
            if ($this->loader->existProxyFile($config) === true) {
                $proxyName = $config->getProxyName();
                $this->loadFile($this->loader->getProxyPath($proxyName));
                return $proxyName;
            }
        }

        $def = $this->generateProxyDefinition($config);

        $this->loader->load($def);

        return $def->getClassName();
    }

    /**
     * 프록시 명세(Definition)을 작성한다.
     *
     * @param ProxyConfig $config 프록시 설정
     *
     * @return Definition
     */
    protected function generateProxyDefinition(ProxyConfig $config)
    {
        $code = file_get_contents(__DIR__.'/Proxy.php.stub');
        foreach ($this->passes as $pass) {
            $code = $pass->apply($code, $config);
        }
        return new Definition($config, $code);
    }

    /**
     * load file
     *
     * @param string $path file path
     *
     * @return void
     */
    protected function loadFile($path)
    {
        require_once($path);
    }
}
