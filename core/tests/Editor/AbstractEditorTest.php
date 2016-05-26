<?php
namespace Xpressengine\Tests\Frontend;

use Mockery as m;
use Xpressengine\Editor\Textarea;

class AbstractEditorTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testLoadTools()
    {
        list($editors, $instanceId) = $this->getMocks();
        $instance = $this->getMock(Dummy::class, ['getTools'], [$editors, $instanceId]);

        $mockTool1 = m::mock('Xpressengine\Editor\AbstractTool');
        $mockTool1->shouldReceive('initAssets');
        $mockTool2 = m::mock('Xpressengine\Editor\AbstractTool');
        $mockTool2->shouldReceive('initAssets');
        $instance->expects($this->once())->method('getTools')->willReturn([$mockTool1, $mockTool2]);

        $this->invokedMethod($instance, 'loadTools');
    }

    public function testGetTools()
    {
        list($editors, $instanceId) = $this->getMocks();
        $instance = $this->getMock(Dummy::class, ['getActivateToolIds'], [$editors, $instanceId]);

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
        list($editors, $instanceId) = $this->getMocks();
        $instance = $this->getMock(
            Dummy::class,
            ['loadTools', 'getOptions', 'getContentHtml', 'getEditorScript'],
            [$editors, $instanceId]
        );

        $instance->expects($this->once())->method('loadTools');
        $instance->expects($this->once())->method('getOptions')
            ->willReturn(['content' => 'content body', 'var' => 'foo']);
        $instance->expects($this->once())->method('getContentHtml')
            ->with('content body', ['content' => 'content body', 'var' => 'foo'])->willReturn('<div>content body</div>');
        $instance->expects($this->once())->method('getEditorScript')
            ->with(['content' => 'content body', 'var' => 'foo'])->willReturn('<script></script>');


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
