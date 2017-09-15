<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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

