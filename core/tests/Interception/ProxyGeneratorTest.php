<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;

use Xpressengine\Interception\Proxy\Definition;
use Xpressengine\Interception\Proxy\Loader\EvalLoader;
use Xpressengine\Interception\Proxy\Loader\FileLoader;
use Xpressengine\Interception\Proxy\Loader\Loader;
use Xpressengine\Interception\Proxy\Pass\Pass;
use Xpressengine\Interception\Proxy\ProxyConfig;
use Xpressengine\Interception\Proxy\ProxyGenerator;

class ProxyGeneratorTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct()
    {
        $this->assertInstanceOf(ProxyGenerator::class, $this->getGenerator());
    }

    public function testGenerateWithNoFileLoader()
    {
        $pass = $this->getPass();
        $pass->shouldReceive('apply')->once()->andReturn('code');

        $loader = $this->getLoader();
        $loader->shouldReceive('load')->with(\Mockery::type(Definition::class))->once()->andReturnNull();

        $generator = $this->getGenerator($loader, [$pass]);

        $proxyClass = $generator->generate(TestTargetClass::class);

        $this->assertEquals(
            'Proxy_Xpressengine_Tests_Interception_TestTargetClass',
            $proxyClass
        );
    }

    public function testGenerateWithFileLoader()
    {
        $pass = $this->getPass();
        $pass->shouldReceive('apply')->once()->andReturn('code');

        $loader = $this->getLoader('FileLoader');
        $loader->shouldReceive('existProxyFile')->with(\Mockery::type(ProxyConfig::class))->once()->andReturn(false);
        $loader->shouldReceive('existProxyFile')->with(\Mockery::type(ProxyConfig::class))->once()->andReturn(true);
        $loader->shouldReceive('getProxyPath')->once()->andReturn('anystring');
        $loader->shouldReceive('load')->with(\Mockery::type(Definition::class))->once()->andReturnNull();

        $generator = \Mockery::mock('\Xpressengine\Interception\Proxy\ProxyGenerator[loadFile]', [$loader, [$pass]])
            ->shouldAllowMockingProtectedMethods();
        $generator->shouldReceive('loadFile')->once()->withAnyArgs()->andReturnNull();

        $proxyClass = $generator->generate(TestTargetClass::class);
        $this->assertEquals(
            'Proxy_Xpressengine_Tests_Interception_TestTargetClass',
            $proxyClass
        );

        $proxyClass = $generator->generate(TestTargetClass::class);
        $this->assertEquals(
            'Proxy_Xpressengine_Tests_Interception_TestTargetClass',
            $proxyClass
        );
    }


    protected function getGenerator(Loader $loader = null, $passes = [])
    {
        if ($loader === null) {
            $loader = $this->getLoader();
        }

        return new ProxyGenerator($loader, $passes);
    }

    private function getLoader($loader = null)
    {
        if ($loader === 'FileLoader') {
            return \Mockery::mock(FileLoader::class);
        } else if ($loader === 'EvalLoader') {
            return \Mockery::mock(EvalLoader::class);
        }
        return \Mockery::mock(Loader::class);
    }

    private function getPass()
    {
        return \Mockery::mock(Pass::class);
    }

}


class TestTargetClass
{
    public function publicMethod()
    {
    }

    public function privateMethod()
    {
    }
}
