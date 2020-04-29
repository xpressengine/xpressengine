<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Seo;

use Mockery as m;
use Xpressengine\Seo\SeoHandler;

class SeoHandlerTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testImport()
    {
        list($importers, $setting, $translator, $frontend, $presenter) = $this->getMocks();
        $instance = m::mock(SeoHandler::class, [$importers, $setting, $translator, $frontend, $presenter])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockItem1 = m::mock('Xpressengine\Seo\SeoUsable');
        $mockItem2 = new \stdClass();
        $mockItem3 = new \stdClass();

        $instance->shouldReceive('resolveData')->once()->with($mockItem1)->andReturn([
            'type' => 'website',
            'siteName' => 'site name',
            'title' => 'site title'
        ]);

        foreach ($importers as $importer) {
            $importer->shouldReceive('exec')->once()->with([
                'type' => 'website',
                'siteName' => 'site name',
                'title' => 'site title'
            ]);
        }

        $instance->import([$mockItem1, $mockItem2, $mockItem3]);
    }

    public function testResolveData()
    {
        list($importers, $setting, $translator, $frontend, $presenter) = $this->getMocks();
        $instance = m::mock(SeoHandler::class, [$importers, $setting, $translator, $frontend, $presenter])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $mockMeta = m::mock('stdClass');
        $mockMeta->width = 200;
        $mockMeta->height = 100;
        $mockImage = m::mock('Xpressengine\Media\Models\Image');
        $mockImage->shouldReceive('url')->once()->andReturn('/path/to/item/image');
        $mockImage->shouldReceive('hasMacro')->andReturn(false);
        $mockImage->shouldReceive('getAttribute')->with('meta')->andReturn($mockMeta);

        $mockItem = m::mock('Xpressengine\Seo\SeoUsable');
        $mockItem->shouldReceive('getUrl')->andReturn('http://someurl.com/path/name');
        $mockItem->shouldReceive('getDescription')->andReturn('sample description');
        $mockItem->shouldReceive('getKeyword')->andReturn(['test', 'sample']);
        $mockItem->shouldReceive('getAuthor')->andReturn('');
        $mockItem->shouldReceive('getImages')->andReturn([$mockImage]);

        $instance->shouldReceive('makeTitle')->once()->with($mockItem)->andReturn('this is sparta!');

        $setting->shouldReceive('get')->once()->with('mainTitle')->andReturn('site name');
       // $setting->shouldReceive('get')->once()->with('description')->andReturn('');
       // $setting->shouldReceive('get')->once()->with('keywords')->andReturn('');

        $translator->shouldReceive('trans')->once()->with('site name')->andReturn('site name');

        $instanceConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $menuItem = m::mock('Xpressengine\Menu\Models\MenuItem');
        $presenter->shouldReceive('getInstanceConfig')->once()->andReturn($instanceConfig);
        $instanceConfig->shouldReceive('getMenuItem')->once()->andReturn($menuItem);
        $menuItem->shouldReceive('hasMacro')->andReturn(false);
        $menuItem->shouldReceive('getAttribute')->with('menuImage')->andReturn('/path/to/site/image');

        $setting->shouldReceive('getSiteImage')->once()->andReturn('/path/to/site/image');

        $data = $this->invokeMethod($instance, 'resolveData', [$mockItem]);

        $this->assertEquals('article', $data['type']);
        $this->assertEquals('site name', $data['siteName']);
        $this->assertEquals('http://someurl.com/path/name', $data['url']);
        $this->assertEquals('this is sparta!', $data['title']);
        $this->assertEquals('sample description', $data['description']);
        $this->assertEquals('test,sample', $data['keywords']);
        $this->assertFalse(isset($data['author']));
        $this->assertEquals(3, count($data['images']));

        $this->assertEquals([
                'url' => '/path/to/item/image',
                'width' => 200,
                'height' => 100
            ], reset($data['images']));
        $this->assertEquals('/path/to/site/image', next($data['images'])['url']);
    }

    public function testMakeTitle()
    {
        list($importers, $setting, $translator, $frontend, $presenter) = $this->getMocks();
        $instance = new SeoHandler($importers, $setting, $translator, $frontend, $presenter);

        $mockItem = m::mock('Xpressengine\Seo\SeoUsable');
        $mockItem->shouldReceive('getTitle')->once()->andReturn('item title');

        $setting->shouldReceive('get')->twice()->with('mainTitle')->andReturn('main title');
        $setting->shouldReceive('get')->once()->with('subTitle')->andReturn('sub title');

        $translator->shouldReceive('trans')->twice()->with('main title')->andReturn('main title');
        $translator->shouldReceive('trans')->once()->with('sub title')->andReturn('sub title');

        $frontend->shouldReceive('output')->with('title')->andReturn('site title');
        $frontend->shouldReceive('title');

        $title = $this->invokeMethod($instance, 'makeTitle', [$mockItem]);
        $this->assertEquals('item title - main title', $title);

        $title = $this->invokeMethod($instance, 'makeTitle');
        $this->assertEquals('main title - sub title', $title);
    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    private function getMocks()
    {
        return [
            [
                m::mock('Xpressengine\Seo\Importers\AbstractImporter')
            ],
            m::mock('Xpressengine\Seo\Setting'),
            m::mock('Xpressengine\Translation\Translator'),
            m::mock('Xpressengine\Presenter\Html\FrontendHandler'),
            m::mock('Xpressengine\Presenter\Presenter')
        ];
    }
}
