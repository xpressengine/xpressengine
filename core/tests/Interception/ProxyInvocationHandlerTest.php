<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;

use Mockery\MockInterface;
use Xpressengine\Interception\Advisor;
use Xpressengine\Interception\AdvisorList;
use Xpressengine\Interception\ProxyInvocationHandler;

class ProxyInvocationHandlerTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testGetTargetObject()
    {
        $handler = $this->getHandler();

        $this->assertInstanceOf('Proxy', $handler->getTargetObject());
    }

    public function testGetTargetMethodName()
    {
        $handler = $this->getHandler();

        $this->assertEquals('originMethod', $handler->getTargetMethodName());
    }

    public function testCallProxyWithEmptyAdvisor()
    {
        $advisorList = $this->getAdvisorList();
        $advisorList->shouldReceive('next')->andReturnNull();
        $handler = $this->getHandler(null, 'origin', $advisorList);

        $args = ['1', '2'];
        $originMethod = function ($a, $b) {
            return $a.$b;
        };

        $this->assertEquals('12', $handler->callProxy($args, $originMethod));
    }

    public function testCallProxyWithAdvisor()
    {
        $advisorList = $this->getAdvisorList();
        $proxyObject = $this->getProxyObject();

        $advisorArr = [
            'a' => \Mockery::mock(Advisor::class, [
                'getAdvice' => function($target, $a, $b) {
                    return 'a'.$target($a, $b);
                }
            ]),
            'b' => \Mockery::mock(Advisor::class, [
                'getAdvice' => function($target, $a, $b) {
                    return 'b'.$target($a, $b);
                }
            ]),
            'c' => \Mockery::mock(Advisor::class, [
                'getAdvice' => function($target, $a, $b) {
                    return 'c'.$target($a, $b);
                }
            ]),
            null
        ];

        /** @var MockInterface $advisorList */
        $advisorList->shouldReceive('next')->andReturnValues($advisorArr);

        $handler = $this->getHandler(null, 'origin', $advisorList);

        $args = ['1', '2'];
        $originMethod = function ($a, $b) {
            return $a.$b;
        };

        $this->assertEquals('abc12', $handler->callProxy($args, $originMethod));
    }

    /**
     * getAdvisorList
     *
     * @param null $proxyObject
     * @param null $sortedList
     * @param null $advisorArr
     *
     * @return AdvisorList
     */
    protected function getHandler($proxyObject = null, $method = 'originMethod', $advisorList = null)
    {

        if ($proxyObject === null) {
            $proxyObject = $this->getProxyObject();
        }
        if ($advisorList === null) {
            $advisorList = $this->getAdvisorList();
        }


        return new ProxyInvocationHandler($proxyObject, $method, $advisorList);
    }


    /**
     * getAdvisorList
     *
     * @param null $proxyObject
     * @param null $sortedList
     * @param null $advisorArr
     *
     * @return AdvisorList
     */
    protected function getAdvisorList($sortedList = null, $advisorArr = null)
    {

        if ($sortedList === null) {
            $sortedList = ['a', 'b', 'c'];
        }
        if ($advisorArr === null) {
            $advisorArr = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
        }

        $list = \Mockery::mock('\Xpressengine\Interception\AdvisorList');
        return $list;
    }


    /**
     * getProxyObject
     *
     * @return \Mockery\MockInterface
     */
    protected function getProxyObject()
    {
        return \Mockery::mock('Proxy');
    }
}
