<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
