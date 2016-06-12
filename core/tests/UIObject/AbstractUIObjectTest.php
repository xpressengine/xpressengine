<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\UIObject;

use Mockery;
use Mockery\Mock;
use Xpressengine\UIObject\AbstractUIObject;

class AbstractUIObjectTest extends \PHPUnit_Framework_TestCase {

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

    public function testRenderWithCallback()
    {
        $markup = Mockery::mock('\PhpQuery\PhpQueryObject');
        $markup->testKey = 'test';
        Mockery::mock('alias:PhpQuery', '\PhpQuery\PhpQuery', [
            'newDocument' => null,
            'pq' => $markup
        ]);

        $uio = new TestUIObject([], function(&$m) use ($markup) {
            $this->assertEquals($markup->testKey, $markup->testKey);
            $m = '<div>markup</div>';
        });

        $this->assertEquals('<div>markup</div>', $uio->render());

    }


    public function testToString()
    {
        $markup = Mockery::mock('\PhpQuery\PhpQueryObject');
        $markup->testKey = 'test';
        Mockery::mock('alias:PhpQuery', '\PhpQuery\PhpQuery', [
            'newDocument' => null,
            'pq' => $markup
        ]);

        $uio = new TestUIObject([], function(&$m) use ($markup) {
            $this->assertEquals($markup->testKey, $markup->testKey);
            $m = '<div>markup</div>';
        });

        $this->assertEquals('<div>markup</div>', (string) $uio);

    }

}

class TestUIObject extends AbstractUIObject
{

    protected $template = '<div>template</div>';

    public static function boot()
    {
    }

    public static function getSettingsURI()
    {
    }
}
