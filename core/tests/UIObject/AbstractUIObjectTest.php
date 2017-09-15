<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\UIObject;

use Xpressengine\UIObject\AbstractUIObject;

class AbstractUIObjectTest extends \PHPUnit\Framework\TestCase {

    public function testSeq()
    {
        TestUIObject::$sequence = 0;
        $this->assertEquals(1, TestUIObject::seq());
        $this->assertEquals(2, TestUIObject::seq());
        $this->assertEquals(3, TestUIObject::seq());
    }

    public function testConstruct()
    {
        $uio = new TestUIObject([]);

        $this->assertInstanceOf('\Xpressengine\Tests\UIObject\TestUIObject', $uio);
    }

    public function testRender()
    {
        $uio = new TestUIObject([]);

        $this->assertEquals('<div>template</div>', $uio->render());

    }

}

class TestUIObject extends AbstractUIObject
{
    protected $template = '<div>template</div>';
}
