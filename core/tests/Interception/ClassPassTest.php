<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;

use Xpressengine\Interception\Proxy\Pass\ClassPass;
use Xpressengine\Interception\Proxy\ProxyConfig;

class ClassPassTest extends \PHPUnit\Framework\TestCase
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
