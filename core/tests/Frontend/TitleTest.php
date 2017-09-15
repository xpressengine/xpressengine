<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Frontend;

use Xpressengine\Presenter\Html\Tags\Title;

class TitleTest extends \PHPUnit\Framework\TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstructAndOutput()
    {
        $title = new Title('hi');
        $output = Title::output();

        $this->assertEquals('hi', $output);
    }

    public function testInit()
    {
        $title = new Title('hi');
        Title::init('hello');
        $output = Title::output();

        $this->assertEquals('hello', $output);
    }
}
