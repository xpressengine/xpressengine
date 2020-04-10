<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Frontend;

use Xpressengine\Presenter\Html\Tags\CSSFile;

class CSSFileTest extends \PHPUnit\Framework\TestCase {

    /**
     * @var CSSFileStub
     */
    protected $cssFile;

    protected function tearDown()
    {
        \Mockery::close();
        $prop = new \ReflectionProperty(CSSFile::class, 'sorted');

        $prop->setAccessible(true);
        $prop->setValue([]);
        $prop->setAccessible(false);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $cssfile = new CSSFileStub('path/to/file1.css');
    }

    public function testConstructMultiFile()
    {
        $cssfile = new CSSFileStub([
            'path/to/file1.css',
            'path/to/file2.css',
            'path/to/file3.css',
            'path/to/file4.css',
        ]);
    }

    public function testOutput()
    {
        $this->cssFile->load();

        $output = CSSFileStub::output();

        $this->assertEquals(
'<link href="path/to/file1.css" type="text/css" rel="stylesheet" media="all">
<link href="path/to/file2.css" type="text/css" rel="stylesheet" media="all">
<link href="path/to/file3.css" type="text/css" rel="stylesheet" media="all">
<link href="path/to/file4.css" type="text/css" rel="stylesheet" media="all">', trim($output));
    }

    public function testTarget()
    {
        $this->cssFile->target('gt IE 10')->load();

        $output = CSSFileStub::output();

        $this->assertEquals(
'<!--[if gt IE 10]><!-->;<link href="path/to/file1.css" type="text/css" rel="stylesheet" media="all">
<![endif]--><!--[if gt IE 10]><!-->;<link href="path/to/file2.css" type="text/css" rel="stylesheet" media="all">
<![endif]--><!--[if gt IE 10]><!-->;<link href="path/to/file3.css" type="text/css" rel="stylesheet" media="all">
<![endif]--><!--[if gt IE 10]><!-->;<link href="path/to/file4.css" type="text/css" rel="stylesheet" media="all">
<![endif]-->', trim($output));
    }



    public function testBefore()
    {
        $this->cssFile->target('gt IE 10')->load();

        $cssfile = new CSSFileStub('path/to/afterfile.css');
        $cssfile->before('path/to/file3.css')->load();

        $output = CSSFileStub::output();

        $this->assertEquals(
'<!--[if gt IE 10]><!-->;<link href="path/to/file1.css" type="text/css" rel="stylesheet" media="all">
<![endif]--><!--[if gt IE 10]><!-->;<link href="path/to/file2.css" type="text/css" rel="stylesheet" media="all">
<![endif]--><!--[if gt IE 10]><!-->;<link href="path/to/file3.css" type="text/css" rel="stylesheet" media="all">
<![endif]--><link href="path/to/afterfile.css" type="text/css" rel="stylesheet" media="all">
<!--[if gt IE 10]><!-->;<link href="path/to/file4.css" type="text/css" rel="stylesheet" media="all">
<![endif]-->', trim($output));
    }

    public function testBefore2()
    {
        $cssfile = new CSSFileStub('path/to/file1.css');
        $cssfile->load();
        $cssfile = new CSSFileStub('path/to/target.css');
        $cssfile->after('path/to/file3.css')->load();
        $cssfile = new CSSFileStub('path/to/file2.css');
        $cssfile->load();
        $cssfile = new CSSFileStub('path/to/file3.css');
        $cssfile->load();
        $cssfile = new CSSFileStub('path/to/file4.css');
        $cssfile->load();

        $output = CSSFileStub::output();

        $this->assertEquals(
'<link href="path/to/file1.css" type="text/css" rel="stylesheet" media="all">
<link href="path/to/target.css" type="text/css" rel="stylesheet" media="all">
<link href="path/to/file3.css" type="text/css" rel="stylesheet" media="all">
<link href="path/to/file2.css" type="text/css" rel="stylesheet" media="all">
<link href="path/to/file4.css" type="text/css" rel="stylesheet" media="all">', trim($output));
    }

    public function testMin()
    {
        $cssfile = new CSSFileStub('path/to/file1.css');
        $cssfile->min('path/to/file1.min.css')->load();

        $output = $cssfile->output('head.append', true);

        $this->assertEquals('<link href="path/to/file1.min.css" type="text/css" rel="stylesheet" media="all">', trim($output));
    }

    public function testType()
    {
        $cssfile = new CSSFileStub('path/to/file1.css');
        $cssfile->type('text/abc')->load();

        $output = $cssfile->output();

        $this->assertEquals('<link href="path/to/file1.css" type="text/abc" rel="stylesheet" media="all">', trim($output));
    }

    protected function setUp()
    {
        CSSFileStub::init();
        $this->cssFile = new CSSFileStub([
            'path/to/file1.css',
            'path/to/file2.css',
            'path/to/file3.css',
            'path/to/file4.css',
        ]);

        parent::setUp();
    }
}

class CSSFileStub extends CSSFile
{
    protected function asset($file)
    {
        return $file;
    }

    public function getFiles()
    {
        return $this->files;
    }
}
