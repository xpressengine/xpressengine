<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
