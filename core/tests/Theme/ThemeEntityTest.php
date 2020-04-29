<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Theme;

use Xpressengine\Theme\ThemeEntity;

class ThemeEntityTest extends \PHPUnit\Framework\TestCase
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

        $this->assertFalse($entity->support('desktop'));
        $this->assertTrue($entity->support('mobile'));
        $this->assertFalse($entity->supportDesktop());
        $this->assertTrue($entity->supportMobile());
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
