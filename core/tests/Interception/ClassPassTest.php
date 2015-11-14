<?php
namespace Xpressengine\Tests\Interception;

use Xpressengine\Interception\Proxy\Pass\ClassPass;
use Xpressengine\Interception\Proxy\ProxyConfig;

class ClassPassTest extends \PHPUnit_Framework_TestCase
{

    const CODE = "namespace Xpressengine\\Interception\\Proxy;  class Proxy{ use ProxyTrait; }";

    public function setup()
    {
        $this->pass = new ClassPass();
    }

    public function testShouldRemoveNamespaceDefinition()
    {
        $config = $this->getConfig("Dave\\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertContains('Proxy_Dave_Dave extends Dave\\Dave', $code);
    }

    public function testShouldRemoveLeadingBackslashesFromNamespace()
    {
        $config = $this->getConfig("\\Dave\\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertContains('Proxy_Dave_Dave extends Dave\\Dave', $code);
    }

    private function getConfig($string)
    {
        $m = \Mockery::mock('\Xpressengine\Interception\Proxy\ProxyConfig');
        $m->shouldReceive('getTargetName')->andReturnUsing(
            function () use ($string) {
                return trim($string, '\\');
            }
        );
        $m->shouldReceive('getProxyName')->andReturnUsing(
            function () use ($string) {
                return 'Proxy_' . str_replace('\\', '_', trim($string, '\\'));
            }
        );
        return $m;
    }
}
