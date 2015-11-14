<?php
namespace Xpressengine\Tests\Interception;


use Mockery;
use ReflectionClass;
use Xpressengine\Interception\Proxy\Pass\MethodDefinitionPass;

class MethodDefinitionPassTest extends \PHPUnit_Framework_TestCase
{
    public function testApply()
    {
        $pass = new MethodDefinitionPass();

        $config = $this->getProxyConfig();

        $rfc = new ReflectionClass('Xpressengine\Tests\MethodDefinitionPassTest\TestTargetClass');
        $methods = $rfc->getMethods(\ReflectionMethod::IS_PUBLIC);
        $config->shouldReceive('getTargetMethods')->once()->andReturn($methods);

        $code = $pass->apply($this->getTestCode(), $config);

        $this->assertContains('public function funcA(array $a)', $code);
        $this->assertContains('public function funcB(Closure $b)', $code);
        $this->assertNotContains('funcC', $code);
        $this->assertContains('use ProxyTrait', $code);
    }

    protected function getProxyConfig()
    {
        return Mockery::mock('Xpressengine\Interception\Proxy\ProxyConfig');
    }

    protected function getTestCode()
    {
        return '<?php

use Xpressengine\Interception\Proxy\ProxyTrait;

class Proxy
{
    use ProxyTrait;
}
';
    }
}

namespace Xpressengine\Tests\MethodDefinitionPassTest;

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


