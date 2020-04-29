<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
