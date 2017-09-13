<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Skin;

function view($view = null, $data = [], $mergeData = [])
{
    return $view;
}

namespace Xpressengine\Tests\Skin;

use Xpressengine\Skin\BladeSkin;

class BladeSkinTest extends \PHPUnit\Framework\TestCase
{
    public function testRender()
    {
        $skin = new TestBladeSkin();
        $data = 'data';
        $ret = $skin->setView('view')->setData($data)->render();

        $this->assertEquals('my.path.view', $ret);
    }

    public function testPath()
    {
        $skin = new TestBladeSkin();

        $this->assertEquals('my.path', $skin->getSkinPath());
        $this->assertEquals('my.path.a.b', $skin->getSkinPath('a.b'));
    }

    public function testRenderUsingMethod()
    {
        $skin = new TestBladeSkin();
        $skin->setView('my.list');
        $this->assertEquals('my.list', $skin->render());
    }

    /**
     * @expectedException \Xpressengine\Skin\Exceptions\PathNotAssignedException
     */
    public function testPathWhenPathNotAssigned()
    {
        $skin = new TestBladeSkinNotAssignPath();
        $skin->getSkinPath();
    }

    /**
     * @expectedException \Xpressengine\Skin\Exceptions\PathNotAssignedException
     */
    public function testRenderWhenPathNotAssigned()
    {
        $skin = new TestBladeSkinNotAssignPath();
        $skin->setView('list')->render();
    }
}

class TestBladeSkin extends BladeSkin
{
    protected static $id = 'test.skin';
    protected $path = 'my.path';

    protected function myList($view)
    {
        return 'my.list';
    }
}

class TestBladeSkinNotAssignPath extends BladeSkin
{
    protected static $id = 'test.skin';
}
