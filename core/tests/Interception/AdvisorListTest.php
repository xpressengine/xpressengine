<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;

use Xpressengine\Interception\Advisor;
use Xpressengine\Interception\AdvisorList;

class AdvisorListTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testGetAll()
    {
        $sorted = $this->getAdvisorList()->getAll();
        $this->assertEquals($sorted, ['a', 'b', 'c']);
    }


    public function testNext()
    {

        $advisorList = $this->getAdvisorList();

        $this->assertEquals($advisorList->next(), 'A');
        $this->assertEquals($advisorList->next(), 'B');
        $this->assertEquals($advisorList->next(), 'C');
        $this->assertNull($advisorList->next());
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

        return new AdvisorList($sortedList, $advisorArr);
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
