<?php
namespace Xpressengine\Tests\Frontend;

use Xpressengine\Presenter\Html\Tags\Title;

class TitleTest extends \PHPUnit_Framework_TestCase {

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
