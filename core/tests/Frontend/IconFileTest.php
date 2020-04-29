<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Frontend;

use Xpressengine\Presenter\Html\Tags\IconFile;

class IconFileTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var IconFileStub
     */
    protected $iconFile;

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $iconFile = new IconFileStub('path/to/file.ico');
        return $iconFile;
    }

    /**
     * @depends testConstruct
     */
    public function testOutput(IconFileStub $iconFile)
    {
        $iconFile->load();
        $output = IconFile::output();

        $this->assertEquals('<link rel="shortcut icon" type="image/x-icon" href="path/to/file.ico">', trim($output));
    }

    public function testSizes()
    {
        $this->iconFile->appleTouchIcon()->sizes('57x57')->load();
        $output = $this->iconFile->output();

        $this->assertEquals('<link rel="apple-touch-icon" sizes="57x57" href="path/to/file.ico">', trim($output));
    }

    public function testType()
    {
        $this->iconFile->type('image/png')->load();
        $output = $this->iconFile->output();

        $this->assertEquals('<link rel="shortcut icon" type="image/png" href="path/to/file.ico">', trim($output));
    }

    protected function setUp()
    {
        IconFile::init();
        $this->iconFile = new IconFileStub('path/to/file.ico');
        parent::setUp();
    }
}

class IconFileStub extends IconFile
{
    protected function asset($file)
    {
        return $file;
    }
}

