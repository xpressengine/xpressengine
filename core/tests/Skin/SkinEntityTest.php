<?php
namespace Xpressengine\Tests\Skin;

use Xpressengine\Skin\SkinEntity;

class SkinEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $entity = new SkinEntity(TestSkin::getId(), TestSkin::class);
        $this->assertInstanceOf(SkinEntity::class, $entity);
    }

    public function testGetters()
    {
        $entity = new SkinEntity(TestSkin::getId(), TestSkin::class);

        $this->assertNull($entity->getTitle());
        $this->assertNull($entity->getDescription());
        $this->assertEquals('screenshot', $entity->getScreenshot());
        $this->assertEquals('http://foo.bar', $entity->getSettingsURI());
    }

    public function testSupports()
    {
        $entity = new SkinEntity(TestSkin::getId(), TestSkin::class);

        $this->assertTrue($entity->supportDesktop());
        $this->assertFalse($entity->supportDesktopOnly());
        $this->assertTrue($entity->supportMobile());
        $this->assertFalse($entity->supportMobileOnly());
    }

    public function testGetObject()
    {
        $entity = new SkinEntity(TestSkin::getId(), TestSkin::class);

        $this->assertInstanceOf('Xpressengine\Skin\AbstractSkin', $entity->getObject());
        $this->assertInstanceOf('Xpressengine\Skin\AbstractSkin', $entity->getObject());
    }

    public function testToArray()
    {
        $entity = new SkinEntity(TestSkin::getId(), TestSkin::class);

        $this->assertEquals(
            [
                'id' => 'test.skin',
                'title' => null,
                'class' => 'Xpressengine\Tests\Skin\TestSkin',
                'description' => null,
                'screenshot' => 'screenshot'
            ],
            $entity->toArray()
        );
    }
}
