<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Tag;

use Mockery as m;
use Xpressengine\Tag\SimpleDecomposer;

class SimpleDecomposerTest extends \PHPUnit_Framework_TestCase
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
