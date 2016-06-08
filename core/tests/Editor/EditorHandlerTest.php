<?php
namespace Xpressengine\Tests\Frontend;

use Mockery as m;
use Xpressengine\Editor\EditorHandler;

class EditorHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetAll()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = new EditorHandler($register, $configs, $container);

        $register->shouldReceive('get')->once()->with('editor')->andReturn([
            'editor/foo@bar' => 'class1',
            'editor/baz@qux' => 'class2'
        ]);

        $all = $instance->getAll();

        $this->assertEquals([
            'editor/foo@bar' => 'class1',
            'editor/baz@qux' => 'class2'
        ], $all);
    }

    public function testSetInstanceThrowsExceptionWhenNotExists()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = new EditorHandler($register, $configs, $container);

        $register->shouldReceive('get')->once()->with('editor/foo@bar')->andReturnNull();

        try {
            $instance->setInstance('someinstanceid', 'editor/foo@bar');

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Editor\Exceptions\EditorNotFoundException', $e);
        }
    }

    public function testSetInstance()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = new EditorHandler($register, $configs, $container);

        $register->shouldReceive('get')->once()->with('editor/foo@bar')->andReturn('stdClass');
        $configs->shouldReceive('set')->once()
            ->with(EditorHandler::CONFIG_NAME, ['someinstanceid' => 'editor/foo@bar']);

        $instance->setInstance('someinstanceid', 'editor/foo@bar');
    }

    public function testGetEditorId()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = new EditorHandler($register, $configs, $container);

        $mockConfig = m::mock('Xpressengine\Config\ConfigEntity');
        $mockConfig->shouldReceive('get')->with('someinstanceid')->andReturn('editor/foo@bar');
        $configs->shouldReceive('get')->once()->with(EditorHandler::CONFIG_NAME)->andReturn($mockConfig);

        $editorId = $instance->getEditorId('someinstanceid');

        $this->assertEquals('editor/foo@bar', $editorId);
    }

    public function testGet()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = $this->getMock(EditorHandler::class, ['getEditorId'], [$register, $configs, $container]);

        $instance->expects($this->once())->method('getEditorId')->with('someinstanceid')->willReturn(null);

        $register->shouldReceive('get')->once()->with('editor/foo@bar')->andReturn('stdClass');
        $container->shouldReceive('make')->once()
            ->with('stdClass', ['instanceId' => 'someinstanceid'])->andReturn(new \stdClass);

        $instance->setDefaultEditorId('editor/foo@bar');
        $editor = $instance->get('someinstanceid');

        $this->assertInstanceOf('stdClass', $editor);
    }

    public function testRender()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = $this->getMock(EditorHandler::class, ['get'], [$register, $configs, $container]);

        $mockEditor = m::mock('Xpressengine\Editor\AbstractEditor');
        $instance->expects($this->once())->method('get')->with('someinstanceid')->willReturn($mockEditor);

        $mockEditor->shouldReceive('setArguments')->once()
            ->with(['var1' => 'foo', 'var2' => 'bar'])->andReturnSelf();
        $mockEditor->shouldReceive('render')->once()->andReturn('<div></div>');

        $html = $instance->render('someinstanceid', ['var1' => 'foo', 'var2' => 'bar']);

        $this->assertEquals('<div></div>', $html);
    }

    public function testGetToolAll()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = new EditorHandler($register, $configs, $container);

        $register->shouldReceive('get')->once()->with('editortool')->andReturn([
            'editortool/foo@bar' => 'class1',
            'editortool/baz@qux' => 'class2'
        ]);

        $all = $instance->getToolAll();

        $this->assertEquals([
            'editortool/foo@bar' => 'class1',
            'editortool/baz@qux' => 'class2'
        ], $all);
    }

    public function testGetTool()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = $this->getMock(EditorHandler::class, ['getToolAll'], [$register, $configs, $container]);

        $instance->expects($this->exactly(2))->method('getToolAll')->willReturn([
            'editortool/foo@bar' => 'class1',
            'editortool/baz@qux' => 'class2'
        ]);
        $container->shouldReceive('make')->once()
            ->with('class1', ['instanceId' => 'someinstanceid'])->andReturn(new \stdClass());

        $tool = $instance->getTool('editortool/foo@bar', 'someinstanceid');
        $this->assertInstanceOf('stdClass', $tool);

        $tool = $instance->getTool('editortool/some@tool', 'someinstanceid');
        $this->assertNull($tool);
    }

    public function testCompile()
    {
        list($register, $configs, $container) = $this->getMocks();
        $instance = $this->getMock(EditorHandler::class, ['get', 'compileTools'], [$register, $configs, $container]);

        $mockEditor = m::mock('Xpressengine\Editor\AbstractEditor');
        $instance->expects($this->once())->method('get')->with('someinstanceid')->willReturn($mockEditor);
        $mockEditor->shouldReceive('compile')->with('<div></div>')->andReturn('<div attr="foo"></div>');

        $instance->expects($this->once())->method('compileTools')
            ->with('someinstanceid', '<div attr="foo"></div>')->willReturn('<div attr="foo"><p></p></div>');

        $content = $instance->compile('someinstanceid', '<div></div>');

        $this->assertEquals('<div attr="foo"><p></p></div>', $content);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Plugin\PluginRegister'),
            m::mock('Xpressengine\Config\ConfigManager'),
            m::mock('Illuminate\Container\Container'),
        ];
    }
}
