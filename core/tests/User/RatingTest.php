<?php
namespace Xpressengine\Tests\User;

use Xpressengine\User\Rating;

class RatingTest extends \PHPUnit_Framework_TestCase
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
