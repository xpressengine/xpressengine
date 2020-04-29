<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Skin;

use Xpressengine\Skin\SkinEntity;

class SkinEntityTest extends \PHPUnit\Framework\TestCase
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
        $this->assertTrue($entity->supportMobile());
        $this->assertTrue($entity->support('desktop'));
        $this->assertTrue($entity->support('mobile'));
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
