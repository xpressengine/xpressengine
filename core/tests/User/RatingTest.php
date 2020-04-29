<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\User;

use Xpressengine\User\Rating;

class RatingTest extends \PHPUnit\Framework\TestCase
{
    public function testCampare()
    {
        $this->assertEquals(-1, Rating::compare(Rating::GUEST, Rating::USER));
        $this->assertEquals(1, Rating::compare(Rating::USER, Rating::GUEST));
        $this->assertEquals(0, Rating::compare(Rating::USER, Rating::USER));
    }

    /**
     * @expectedException \Xpressengine\User\Exceptions\UnknownCriterionException
     */
    public function testCampareThrowException()
    {
        Rating::compare(Rating::USER, 'foo');
    }

}
