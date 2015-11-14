<?php
namespace Xpressengine\Theme;

function asset($value)
{
    return $value;
}

namespace Xpressengine\Tests\Theme;

use Xpressengine\Theme\AbstractTheme;

class AbstractThemeTest extends \PHPUnit_Framework_TestCase {

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

class TestTheme extends AbstractTheme
{
    protected static $id = 'theme/test@theme';
    protected static $supportDesktop = false;
    protected static $supportMobile = true;

    protected static $componentInfo = [
        'name' => 'Test Theme',
        'description' => 'blur~~ blur~~',
        'screenshot' => 'screenshot',
    ];

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
    }

    public static function getEditFiles()
    {
        return ['foo'];
    }

    /**
     * return settings manage uri
     *
     * @return null|string
     */
    public static function getSettingsURI()
    {
        return 'http://foo.bar';
    }


}
