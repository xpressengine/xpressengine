<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Frontend;

use Xpressengine\Presenter\Html\Tags\Html;

class HtmlTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Html
     */
    protected $html;

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $html = new Html('html1');
        $this->assertInstanceOf('Xpressengine\Presenter\Html\Tags\Html', $html);

        $html2 = new Html('alias');
        $this->assertInstanceOf('Xpressengine\Presenter\Html\Tags\Html', $html2);

        return $html;
    }

    /**
     * @depends testConstruct
     */
    public function testOutput(Html $html)
    {
        $html->content('<div></div>')->load();
        $output = Html::output('body.append');
        $this->assertEquals('<!-- html1 -->'.PHP_EOL.'<div></div>', trim($output));
    }

    public function testOutputComposer()
    {
        $html = new Html('hi');
        $html->content(function(){
            return 'hi';
        })->load();
        $output = Html::output('body.append');
        $this->assertEquals('<!-- hi -->'.PHP_EOL.'hi', trim($output));
    }

    public function testAppendTo()
    {
        $content = '<p>pp</p>';
        $this->html->content($content)->appendTo('head')->load();

        $output = Html::output('body.append');

        $this->assertEmpty($output);

        $output = Html::output('head.append');

        $this->assertEquals($content, trim($output));
    }

    public function testPrependTo()
    {
        $content = '<p>pp</p>';
        $this->html->content($content)->prependTo('head')->load();

        $output = Html::output('body.prepend');

        $this->assertEmpty($output);

        $output = Html::output('head.prepend');

        $this->assertEquals($content, trim($output));
    }

    public function testMultiplePrependTo()
    {
        $html = new Html();
        $html->content('<span>1</span>');
        $html->prependTo('head')->load();

        $html = new Html();
        $html->content('<span>2</span>');
        $html->prependTo('head')->load();

        $html = new Html();
        $html->content('<span>3</span>');
        $html->prependTo('head')->load();

        $output = Html::output('head.prepend');

        $this->assertEquals('<span>1</span>
<span>2</span>
<span>3</span>', trim($output));
    }

    protected function setUp()
    {
        Html::init();
        $this->html = new Html();
        parent::setUp();
    }
}
