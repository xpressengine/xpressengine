<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\User;

use Xpressengine\User\Rating;

class RatingTest extends \PHPUnit\Framework\TestCase
{
    public function testCampare()
    {
        $this->assertEquals(-1, Rating::compare(Rating::GUEST, Rating::MEMBER));
        $this->assertEquals(1, Rating::compare(Rating::MEMBER, Rating::GUEST));
        $this->assertEquals(0, Rating::compare(Rating::MEMBER, Rating::MEMBER));
    }

    /**
     * @expectedException \Xpressengine\User\Exceptions\UnknownCriterionException
     */
    public function testCampareThrowException()
    {
        Rating::compare(Rating::MEMBER, 'foo');
    }

}
