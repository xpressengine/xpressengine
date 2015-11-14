<?php
namespace Xpressengine\Tests\Theme;

use Xpressengine\Theme\ThemeEntity;

class ThemeEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $entity = new ThemeEntity(TestTheme::getId(), TestTheme::class);
        $this->assertInstanceOf(ThemeEntity::class, $entity);
    }

    public function testGetters()
    {
        $entity = new ThemeEntity(TestTheme::getId(), TestTheme::class);

        $this->assertEquals('Test Theme', $entity->getTitle());
        $this->assertEquals('blur~~ blur~~', $entity->getDescription());
        $this->assertEquals(['foo'], $entity->getEditFiles());
        $this->assertEquals('screenshot', $entity->getScreenshot());
        $this->assertEquals('http://foo.bar', $entity->getSettingsURI());
    }

    public function testSupports()
    {
        $entity = new ThemeEntity(TestTheme::getId(), TestTheme::class);

        $this->assertFalse($entity->supportDesktop());
        $this->assertFalse($entity->supportDesktopOnly());
        $this->assertTrue($entity->supportMobile());
        $this->assertTrue($entity->supportMobileOnly());
    }

    public function testGetObject()
    {
        $entity = new ThemeEntity(TestTheme::getId(), TestTheme::class);

        $this->assertInstanceOf('Xpressengine\Theme\AbstractTheme', $entity->getObject());
        $this->assertInstanceOf('Xpressengine\Theme\AbstractTheme', $entity->getObject());
    }

    public function testToArray()
    {
        $entity = new ThemeEntity(TestTheme::getId(), TestTheme::class);

        $this->assertEquals(
            [
                'id' => 'theme/test@theme',
                'title' => 'Test Theme',
                'class' => 'Xpressengine\Tests\Theme\TestTheme',
                'description' => 'blur~~ blur~~',
                'screenshot' => 'screenshot'
            ],
            $entity->toArray()
        );
    }
}
