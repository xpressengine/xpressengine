<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;

use Xpressengine\Interception\Advisor;

class AdvisorTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testCreate()
    {
        $advisor = new Advisor(
            'ad1', 'TargetClass@originMethod', function ($target, $args) {
            return $target($args);
        }
        );

        $this->assertNotNull($advisor);

        return $advisor;
    }

    public function testCreateWithBefore()
    {

        $advisor = new Advisor(
            'ad1', 'TargetClass@originMethod', function ($target, $args) {
            return $target($args);
        }
        );

        $this->assertNotNull($advisor);
    }

    /**
     * @depends testCreate
     *
     */
    public function testGetName(Advisor $advisor)
    {
        $this->assertEquals('ad1', $advisor->getName());
    }

    /**
     * @depends testCreate
     *
     */
    public function testSetName(Advisor $advisor)
    {
        $advisor->setName('ad11');
        $this->assertEquals('ad11', $advisor->getName());
    }

    /**
     * @depends testCreate
     *
     */
    public function testGetPointCut(Advisor $advisor)
    {
        $this->assertEquals(['TargetClass@originMethod'], $advisor->getPointCut());
    }

    /**
     * @depends testCreate
     *
     */
    public function testSetPointCut(Advisor $advisor)
    {
        $advisor->setPointCut('TargetClass@originMethod2');
        $this->assertEquals(['TargetClass@originMethod2'], $advisor->getPointCut());
    }

    /**
     * @depends testCreate
     *
     */
    public function testGetAdvice(Advisor $advisor)
    {
        $advice = $advisor->getAdvice();

        $this->assertEquals(
            'foo',
            $advice(
                function ($arg) {
                    return $arg;
                },
                'foo'
            )
        );
    }

    /**
     * @depends testCreate
     *
     */
    public function testSetAdvice(Advisor $advisor)
    {
        $advisor->setAdvice(
            function ($target, $args) {
                return $target($args).'bar';
            }
        );

        $advice = $advisor->getAdvice();

        $this->assertEquals(
            'foobar',
            $advice(
                function ($arg) {
                    return $arg;
                },
                'foo'
            )
        );
    }
}
