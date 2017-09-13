<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;


use ReflectionMethod;
use Xpressengine\Interception\Proxy\ProxyConfig;

class ProxyConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $config = new ProxyConfig('\Xpressengine\Tests\ProxyConfigTest\TestTargetClass');

        $this->assertInstanceOf('\Xpressengine\Interception\Proxy\ProxyConfig', $config);
    }

    public function testGetTargetMethods()
    {
        $config = new ProxyConfig('\Xpressengine\Tests\ProxyConfigTest\TestTargetClass');
        $methods = $config->getTargetMethods();

        $this->assertCount(2, $methods);
        $funA = array_shift($methods);

        $this->assertInstanceOf(ReflectionMethod::class, $funA);
        $this->assertEquals('funcA', $funA->getName());
    }

    public function testGetTargetName()
    {
        $config = new ProxyConfig('\Xpressengine\Tests\ProxyConfigTest\TestTargetClass');
        $name = $config->getTargetName();

        $this->assertEquals('Xpressengine\Tests\ProxyConfigTest\TestTargetClass', $name);


    }

    public function testGetProxyName()
    {
        $config = new ProxyConfig('\Xpressengine\Tests\ProxyConfigTest\TestTargetClass');
        $name = $config->getProxyName();

        $this->assertEquals('Proxy_Xpressengine_Tests_ProxyConfigTest_TestTargetClass', $name);
    }

    public function testGetTargetPath()
    {
        $config = new ProxyConfig('\Xpressengine\Tests\ProxyConfigTest\TestTargetClass');
        $path = $config->getTargetPath();

        $this->assertEquals(__FILE__, $path);
    }
}

namespace Xpressengine\Tests\ProxyConfigTest;

class TestTargetClass
{
    public function funcA(array $a)
    {
        return "funcA";
    }

    public function funcB(\Closure $b)
    {
        return "funcB";
    }

    protected function funC()
    {
        return "funcC";
    }
}


