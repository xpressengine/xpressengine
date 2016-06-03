<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Theme;

use Xpressengine\Theme\ThemeEntityInterface;

class ThemeEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $entity = new ThemeEntityInterface(TestTheme::getId(), TestTheme::class);
        $this->assertInstanceOf(ThemeEntityInterface::class, $entity);
    }

    public function testGetters()
    {
        $entity = new ThemeEntityInterface(TestTheme::getId(), TestTheme::class);

        $this->assertEquals('Test Theme', $entity->getTitle());
        $this->assertEquals('blur~~ blur~~', $entity->getDescription());
        $this->assertEquals(['foo'], $entity->getEditFiles());
        $this->assertEquals('screenshot', $entity->getScreenshot());
        $this->assertEquals('http://foo.bar', $entity->getSettingsURI());
    }

    public function testSupports()
    {
        $entity = new ThemeEntityInterface(TestTheme::getId(), TestTheme::class);

        $this->assertFalse($entity->supportDesktop());
        $this->assertFalse($entity->supportDesktopOnly());
        $this->assertTrue($entity->supportMobile());
        $this->assertTrue($entity->supportMobileOnly());
    }

    public function testGetObject()
    {
        $entity = new ThemeEntityInterface(TestTheme::getId(), TestTheme::class);

        $this->assertInstanceOf('Xpressengine\Theme\AbstractTheme', $entity->getObject());
        $this->assertInstanceOf('Xpressengine\Theme\AbstractTheme', $entity->getObject());
    }

    public function testToArray()
    {
        $entity = new ThemeEntityInterface(TestTheme::getId(), TestTheme::class);

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
