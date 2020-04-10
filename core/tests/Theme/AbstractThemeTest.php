<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Theme;

require_once 'TestTheme.php';

function asset($value)
{
    return $value;
}

namespace Xpressengine\Tests\Theme;

class AbstractThemeTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testCreate()
    {
        $theme = new TestTheme();
        $this->assertInstanceOf('\Xpressengine\Theme\AbstractTheme', $theme);

        return $theme;
    }

    public function testGetTitle()
    {
        $theme = new TestTheme();
        $this->assertEquals('Test Theme', $theme->getTitle());
    }

    public function testGetScreeshot()
    {
        $theme = new TestTheme();
        $this->assertEquals('screenshot', $theme->getScreenshot());
    }

    public function testGetEditFiles()
    {
        $theme = new TestTheme();
        $this->assertEquals(['foo'], $theme->getEditFiles());
    }
}
