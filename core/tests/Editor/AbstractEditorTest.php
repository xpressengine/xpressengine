<?php
namespace Xpressengine\Tests\Frontend;

use Mockery as m;
use Xpressengine\Editor\Textarea;

class AbstractEditorTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testLoadTools()
    {
        list($editors, $urls, $gate, $skins, $events, $frontend, $instanceId) = $this->getMocks();
        $instance = $this->getMockBuilder(Dummy::class)
            ->setMethods(['getTools'])
            ->setConstructorArgs([$editors, $urls, $gate, $skins, $events, $frontend, $instanceId])
            ->getMock();

        $mockTool1 = m::mock('Xpressengine\Editor\AbstractTool');
        $mockTool1->shouldReceive('initAssets');
        $mockTool2 = m::mock('Xpressengine\Editor\AbstractTool');
        $mockTool2->shouldReceive('initAssets');
        $instance->expects($this->once())->method('getTools')->willReturn([$mockTool1, $mockTool2]);

        $this->invokedMethod($instance, 'loadTools');
    }

    public function testGetTools()
    {
        list($editors, $urls, $gate, $skins, $events, $frontend, $instanceId) = $this->getMocks();
        $instance = $this->getMockBuilder(Dummy::class)
            ->setMethods(['getActivateToolIds'])
            ->setConstructorArgs([$editors, $urls, $gate, $skins, $events, $frontend, $instanceId])
            ->getMock();

        $instance->expects($this->once())->method('getActivateToolIds')->willReturn([
            'editortool/foo@bar',
            'editortool/baz@qux'
        ]);

        $mockTool = m::mock('Xpressengine\Editor\AbstractTool');
        $editors->shouldReceive('getTool')->once()->with('editortool/foo@bar', $instanceId)->andReturn($mockTool);
        $editors->shouldReceive('getTool')->once()->with('editortool/baz@qux', $instanceId)->andReturnNull();

        $tools = $instance->getTools();

        $this->assertEquals([$mockTool], $tools);
    }

    public function testRender()
    {
        list($editors, $urls, $gate, $skins, $events, $frontend, $instanceId) = $this->getMocks();
        $instance = $this->getMockBuilder(Dummy::class)
            ->setMethods(['loadTools', 'getOptions', 'getContentHtml', 'getEditorScript'])
            ->setConstructorArgs([$editors, $urls, $gate, $skins, $events, $frontend, $instanceId])
            ->getMock();

        $instance->expects($this->once())->method('loadTools');
        $instance->expects($this->once())->method('getOptions')
            ->willReturn(['content' => 'content body', 'var' => 'foo']);
        $instance->expects($this->once())->method('getContentHtml')->willReturn('<div>content body</div>');
        $instance->expects($this->once())->method('getEditorScript')
            ->with(['content' => 'content body', 'var' => 'foo'])->willReturn('<script></script>');

        $events->shouldReceive('fire')->once();
        $frontend->shouldReceive('js')->once()->andReturnSelf();
        $frontend->shouldReceive('load')->once();

        $content = $instance->render();

        $this->assertEquals('<div>content body</div><script></script>', $content);
    }

    private function invokedMethod($object, $methodName, $arguments = [])
    {
        $rfc = new \ReflectionClass($object);
        $method = $rfc->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $arguments);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Editor\EditorHandler'),
            m::mock('Illuminate\Contracts\Routing\UrlGenerator'),
            m::mock('Illuminate\Contracts\Auth\Access\Gate'),
            m::mock('Xpressengine\Skin\SkinHandler'),
            m::mock('Illuminate\Contracts\Events\Dispatcher'),
            m::mock('Xpressengine\Presenter\Html\FrontendHandler'),
            'someinstanceid'
        ];
    }
}

class Dummy extends Textarea
{
    protected function resolveConfig($instanceId)
    {
        return m::mock('Xpressengine\Config\ConfigEntity');
    }
}
