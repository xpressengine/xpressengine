<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Frontend;

use Xpressengine\Presenter\Html\Tags\JSFile;

class JSFileTest extends \PHPUnit\Framework\TestCase {

    /**
     * @var JSFileStub
     */
    protected $jsFile;

    protected function tearDown()
    {
        \Mockery::close();
        $prop = new \ReflectionProperty(JSFile::class, 'sorted');

        $prop->setAccessible(true);
        $prop->setValue([]);
        $prop->setAccessible(false);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $jsfile = new JSFileStub('path/to/file1.js');
    }

    public function testConstructMultiFile()
    {
        $jsfile = new JSFileStub([
            'path/to/file1.js',
            'path/to/file2.js',
            'path/to/file3.js',
            'path/to/file4.js',
        ]);
    }

    public function testOutput()
    {
        $this->jsFile->load();

        $output = JSFileStub::output('body.append');

        $this->assertEquals(
'<script src="path/to/file1.js"></script>
<script src="path/to/file2.js"></script>
<script src="path/to/file3.js"></script>
<script src="path/to/file4.js"></script>', trim($output));
    }

    public function testTarget()
    {
        $this->jsFile->target('gt IE 10')->load();

        $output = JSFileStub::output('body.append');

        $this->assertEquals(
'<!--[if gt IE 10]><!-->;<script src="path/to/file1.js"></script>
<![endif]--><!--[if gt IE 10]><!-->;<script src="path/to/file2.js"></script>
<![endif]--><!--[if gt IE 10]><!-->;<script src="path/to/file3.js"></script>
<![endif]--><!--[if gt IE 10]><!-->;<script src="path/to/file4.js"></script>
<![endif]-->', trim($output));
    }

    public function testAppendTo()
    {
        $jsfile = new JSFileStub('path/to/afterfile.js');
        $jsfile->appendTo('head')->load();

        $output = JSFileStub::output('head.prepend');
        $this->assertEquals('', $output);
        $output = JSFileStub::output('body.prepend');
        $this->assertEquals('', $output);
        $output = JSFileStub::output('body.append');
        $this->assertEquals('', $output);

        $output = JSFileStub::output('head.append');

        $this->assertEquals('<script src="path/to/afterfile.js"></script>', trim($output));
    }

    public function testPrependTo()
    {
        $jsfile = new JSFileStub('path/to/file1.js');
        $jsfile->prependTo('body')->load();

        $output = JSFileStub::output('head.prepend');
        $this->assertEquals('', $output);
        $output = JSFileStub::output('head.append');
        $this->assertEquals('', $output);
        $output = JSFileStub::output('body.append');
        $this->assertEquals('', $output);

        $output = JSFileStub::output('body.prepend');

        $this->assertEquals('<script src="path/to/file1.js"></script>', trim($output));
    }



    public function testBefore()
    {
        $this->jsFile->target('gt IE 10')->load();

        $jsfile = new JSFileStub('path/to/afterfile.js');
        $jsfile->before('path/to/file3.js')->load();

        $output = JSFileStub::output('body.append');

        $this->assertEquals(
'<!--[if gt IE 10]><!-->;<script src="path/to/file1.js"></script>
<![endif]--><!--[if gt IE 10]><!-->;<script src="path/to/file2.js"></script>
<![endif]--><!--[if gt IE 10]><!-->;<script src="path/to/file3.js"></script>
<![endif]--><script src="path/to/afterfile.js"></script>
<!--[if gt IE 10]><!-->;<script src="path/to/file4.js"></script>
<![endif]-->', trim($output));
    }

    public function testBefore2()
    {
        $jsfile = new JSFileStub('path/to/file1.js');
        $jsfile->load();
        $jsfile = new JSFileStub('path/to/target.js');
        $jsfile->after('path/to/file3.js')->load();
        $jsfile = new JSFileStub('path/to/file2.js');
        $jsfile->load();
        $jsfile = new JSFileStub('path/to/file3.js');
        $jsfile->load();
        $jsfile = new JSFileStub('path/to/file4.js');
        $jsfile->load();

        $output = JSFileStub::output('body.append');

        $this->assertEquals(
'<script src="path/to/file1.js"></script>
<script src="path/to/target.js"></script>
<script src="path/to/file3.js"></script>
<script src="path/to/file2.js"></script>
<script src="path/to/file4.js"></script>', trim($output));
    }

    public function testMin()
    {
        $jsfile = new JSFileStub('path/to/file1.js');
        $jsfile->min('path/to/file1.min.js')->load();

        $output = $jsfile->output('body.append', true);

        $this->assertEquals('<script src="path/to/file1.min.js"></script>', trim($output));
    }

    public function testType()
    {
        $jsfile = new JSFileStub('path/to/file1.js');
        $jsfile->type('javascript/abc')->load();

        $output = $jsfile->output('body.append', true);

        $this->assertEquals('<script src="path/to/file1.js" type="javascript/abc"></script>', trim($output));
    }

    protected function setUp()
    {
        JSFileStub::init();
        $this->jsFile = new JSFileStub([
            'path/to/file1.js',
            'path/to/file2.js',
            'path/to/file3.js',
            'path/to/file4.js',
        ]);

        parent::setUp();
    }
}

class JSFileStub extends JSFile
{
    protected function resolveKey($file)
    {
        return $file;
    }

    public function getFiles()
    {
        return $this->files;
    }
}
