<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tests\Translation;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Translation\LangData;
use Xpressengine\Translation\Loaders\LangFileLoader;

class LangFileLoaderTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFileLoad()
    {
        $fileSystem = $this->getFileSystem();
        $fileSystem->shouldReceive('getRequire')->with('groupKey')->andReturn(['xe' => 'cms']);

        $loader = new LangFileLoader($fileSystem);
        $this->assertNotNull($loader->load('groupKey'));
    }

    protected function getFileSystem()
    {
        return m::mock('Illuminate\Filesystem\Filesystem');
    }
}
