<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Support;

use Xpressengine\Support\Caster;

class CasterTest extends \PHPUnit\Framework\TestCase
{
    public function testVarious()
    {
        $this->assertSame(123, Caster::cast('123'));
        $this->assertSame(123, Caster::cast(123));
        $this->assertSame(1.234, Caster::cast('1.234'));
        $this->assertSame('abcd', Caster::cast('abcd'));
        $this->assertSame('1,2,3', Caster::cast('1,2,3'));
        $this->assertSame('1234a', Caster::cast('1234a'));
        $this->assertTrue(Caster::cast('true'));
        $this->assertTrue(Caster::cast(true));
        $this->assertFalse(Caster::cast('false'));
        $this->assertFalse(Caster::cast(false));
        $this->assertSame(1, Caster::cast('1'));
        $this->assertSame(1, Caster::cast(1));
        $this->assertSame(0, Caster::cast('0'));
        $this->assertSame(0, Caster::cast(0));
    }
}
