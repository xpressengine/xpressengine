<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Tag;

use Mockery as m;
use Xpressengine\Tag\SimpleDecomposer;

class SimpleDecomposerTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testExecute()
    {
        $instance = new SimpleDecomposer();

        $this->assertEquals('ㄱㅏㄴㅏㄷㅏ', $instance->execute('가나다'));
        $this->assertEquals('ㄱㅏabㄴㅏcㄷㅏde', $instance->execute('가ab나c다de'));
        $this->assertEquals('aㄱㅏㄴㅏ bcㄷㅏ de', $instance->execute('a가나 bc다 de'));
    }
}
