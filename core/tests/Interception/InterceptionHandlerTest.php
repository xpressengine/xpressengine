<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;

use Xpressengine\Interception\Advisor;
use Xpressengine\Interception\AdvisorCollection;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Interception\Proxy\Loader\EvalLoader;
use Xpressengine\Interception\Proxy\Loader\FileLoader;
use Xpressengine\Interception\Proxy\Loader\Loader;
use Xpressengine\Interception\Proxy\ProxyGenerator;

class InterceptionHandlerTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $interceptor = $this->getHandler();

        $this->assertInstanceOf(InterceptionHandler::class, $interceptor);
    }

    public function testGetAdvisorCollection()
    {
        $this->assertInstanceOf(AdvisorCollection::class, $this->getHandler()->getAdvisorCollection());
    }

    public function testAddAdvisor()
    {

        $collection = $this->getCollection();
        $collection->shouldReceive('put')->once()->with(
            \Mockery::type(Advisor::class),
            ['before' => null, 'after' => null]
        )->andReturnNull();

        $interceptor = $this->getHandler($collection);
        $advisor = $interceptor->addAdvisor(
            'Xpressengine\Tests\Interception\Document@insertDocument',
            'spamfilter',
            function ($target, $args) {
                return $target($args);
            }
        );

        $this->assertInstanceOf(Advisor::class, $advisor);
        $this->assertEquals('spamfilter', $advisor->getName());
    }

    public function testProxy()
    {
        $collection = $this->getCollection();
        $targetClassName = '\Xpressengine\Tests\Interception\TestTargetClass';
        $collection->shouldReceive('setAlias')
            ->with('TestTarget', $targetClassName)
            ->andReturnNull();

        $generator = $this->getGenerator();
        $generator->shouldReceive('generate')->with($targetClassName)->andReturn('ProxyClassName');

        $handler = $this->getHandler($collection, $generator);

        $this->assertEquals('ProxyClassName', $handler->proxy($targetClassName, 'TestTarget'));
    }


    protected function getHandler($advisorCollection = null, $generator = null)
    {

        if ($advisorCollection === null) {
            $advisorCollection = $this->getCollection();
        }
        if ($generator === null) {
            $generator = $this->getGenerator();
        }

        return new InterceptionHandler($advisorCollection, $generator);
    }

    private function getCollection()
    {
        $m = \Mockery::mock(AdvisorCollection::class);
        return $m;
    }

    private function getGenerator()
    {
        return \Mockery::mock(ProxyGenerator::class);
    }
}
