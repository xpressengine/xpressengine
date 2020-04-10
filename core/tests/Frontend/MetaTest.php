<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Frontend;

use Xpressengine\Presenter\Html\Tags\Meta;

class MetaTest extends \PHPUnit\Framework\TestCase
{


    /**
     * @var Meta
     */
    protected $meta;

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $meta = new Meta();
    }

    public function testDuplicateAlias()
    {
        $meta = new Meta('a');
        $meta->httpEquiv('httpEquiv')->content('aa')->load();
        $meta = new Meta('b');
        $meta->httpEquiv('httpEquiv')->content('bb')->load();
        $meta = new Meta('a');
        $meta->httpEquiv('httpEquiv')->content('cc')->load();

        $output = Meta::output();

        $this->assertContains('<meta http-equiv="httpEquiv" content="cc">', $output);
        $this->assertContains('<meta http-equiv="httpEquiv" content="bb">', $output);
        $this->assertNotContains('<meta http-equiv="httpEquiv" content="aa">', $output);
    }

    public function testUnload()
    {
        $meta = new Meta('a');
        $meta->httpEquiv('httpEquiv')->content('aa')->load();
        $meta = new Meta('b');
        $meta->httpEquiv('httpEquiv')->content('bb')->load();
        $meta = new Meta('c');
        $meta->httpEquiv('httpEquiv')->content('cc')->load();

        $meta = new Meta('a');
        $meta->unload();

        $output = Meta::output();

        $this->assertContains('<meta http-equiv="httpEquiv" content="cc">', $output);
        $this->assertContains('<meta http-equiv="httpEquiv" content="bb">', $output);
        $this->assertNotContains('<meta http-equiv="httpEquiv" content="aa">', $output);
    }

    public function testName()
    {
        $meta = new Meta();
        $meta->name('keyword')->content('key, word');
        return $meta;
    }

    /**
     * @depends testName
     */
    public function testContent(Meta $meta)
    {
        $meta->content('key, word');
        return $meta;
    }

    /**
     * @depends testContent
     */
    public function testOutput(Meta $meta)
    {
        $meta->load();
        $output = Meta::output();

        $this->assertEquals('<meta name="keyword" content="key, word">', trim($output));
    }

    public function testCharset()
    {
        $meta = new Meta();
        $meta->charset('UTF-8')->load();
        $output = Meta::output();

        $this->assertEquals('<meta charset="UTF-8">', trim($output));
    }

    public function testProperty()
    {
        $meta = new Meta();
        $meta->property('keywords')->load();
        $output = Meta::output();

        $this->assertEquals('<meta property="keywords">', trim($output));
    }

    public function testOutputMulti()
    {
        $meta = new Meta();
        $meta->name('keyword')->content('k,e,y')->load();
        $meta = new Meta();
        $meta->name('description')->content('d,e,s,c')->load();
        $meta = new Meta();
        $meta->httpEquiv('a')->content('b')->load();

        $output = Meta::output();

        $this->assertEquals(
            '<meta name="keyword" content="k,e,y">
<meta name="description" content="d,e,s,c">
<meta http-equiv="a" content="b">',
            trim($output)
        );
    }

    protected function setUp()
    {
        Meta::init();
        $this->meta = new Meta();
        parent::setUp();
    }
}
