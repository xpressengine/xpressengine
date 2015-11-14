<?php
namespace Xpressengine\Tests\Tag;

use Mockery as m;
use Xpressengine\Tag\Decomposer;

class DecomposerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testExecute()
    {
        $instance = new Decomposer();

        $this->assertEquals('ㄱㅏㄴㅏㄷㅏ', $instance->execute('가나다'));
        $this->assertEquals('ㄱㅏabㄴㅏcㄷㅏde', $instance->execute('가ab나c다de'));
        $this->assertEquals('aㄱㅏㄴㅏ bcㄷㅏ de', $instance->execute('a가나 bc다 de'));
    }
}
