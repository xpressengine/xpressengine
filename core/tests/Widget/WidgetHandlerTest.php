<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Support\Exceptions {

    /**
     * xe_trans
     *
     * @param $message
     * @param $args
     *
     * @return string
     */
    function xe_trans($message, $args)
    {
        return 'translate test code';
    }
}


namespace Xpressengine\Tests\Widget {

    use PHPUnit_Framework_TestCase;
    use Mockery as m;

    use Xpressengine\Widget\AbstractWidget;
    use Xpressengine\Widget\WidgetHandler;

    /**
     * Class FakeWidget
     *
     * @package Xpressengine\Tests\Widget
     */
    class FakeWidget extends AbstractWidget
    {
        /**
         * @var array
         */
        public static $ratingWhiteList = ['super', 'manager', 'member'];

        /**
         * init
         *
         * @return void
         */
        protected function init()
        {
            // TODO: Implement init() method.
        }

        /**
         * getSettingForm
         *
         * @param array $args
         *
         * @return string
         */
        public function renderSetting(array $args = [])
        {
            return 'fake Setup String';
        }

        /**
         * boot
         *
         * @return void
         */
        public static function boot()
        {
            // TODO: Implement boot() method.
        }

        /**
         * getSettingsURI
         *
         * @return void
         */
        public static function getSettingsURI()
        {
            // TODO: Implement getSettingsURI() method.
        }

        /**
         * render
         *
         * @return mixed
         * @internal param array $args to render parameter array
         *
         */
        public function render()
        {
            $dummyView = m::mock('Illuminate\Contracts\Support\Renderable');
            $dummyView->shouldReceive('render')->andReturn('fake Render String');
            return $dummyView;
        }
    }

    /**
     * Class WidgetHandlerTest
     *
     * @package Xpressengine\Tests\Widget
     */
    class WidgetHandlerTest extends PHPUnit_Framework_TestCase
    {
        /**
         * @var \Mockery\MockInterface $guard
         */
        protected $guard;
        /**
         * @var \Mockery\MockInterface $register
         */
        protected $register;
        /**
         * @var \Mockery\MockInterface $register
         */
        protected $factory;

        /**
         * @var string
         */
        private $fakeWidgetClassName = 'Xpressengine\Tests\Widget\FakeWidget';

        /**
         * tearDown
         *
         * @return void
         */
        public function tearDown()
        {
            m::close();
        }

        /**
         * testGetClassName
         *
         * @return void
         */
        public function testGetClassName()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn($this->fakeWidgetClassName);

            $mockUser = m::mock('Xpressengine\User\UserInterface');
            $mockUser->shouldReceive('getRating')->andReturn('super');

            $guard = $this->guard;
            $guard->shouldReceive('user')->andReturn($mockUser);

            $widgetClassName = $widgetHandler->getClassName('widget/xpressengine@testWidgetId');

            $this->assertEquals($this->fakeWidgetClassName, $widgetClassName);

        }

        /**
         * testRender
         *
         * @return void
         */
        public function testRender()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn($this->fakeWidgetClassName);

            $mockUser = m::mock('Xpressengine\User\UserInterface');
            $mockUser->shouldReceive('getRating')->andReturn('super');

            $guard = $this->guard;
            $guard->shouldReceive('user')->andReturn($mockUser);

            $fakeWidgetRenderString = $widgetHandler->render('testWidgetId', []);

            $this->assertEquals('fake Render String', $fakeWidgetRenderString);
        }

        /**
         * testRenderNoGuard
         *
         * @return void
         */
        public function testRenderNoGuard()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn($this->fakeWidgetClassName);

            $mockUser = m::mock('Xpressengine\User\UserInterface');
            $mockUser->shouldReceive('getRating')->andReturn('guest');

            $guard = $this->guard;
            $guard->shouldReceive('user')->andReturn($mockUser);

            $fakeWidgetRenderString = $widgetHandler->render('testWidgetId', []);

            $this->assertEquals('', $fakeWidgetRenderString);
        }

        /**
         * testRenderExceptionOccurOnSuper
         *
         * @return void
         */
        public function testRenderExceptionOccurOnSuper()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn(null);

            $mockUser = m::mock('Xpressengine\User\UserInterface');
            $mockUser->shouldReceive('getRating')->andReturn('super');

            $guard = $this->guard;
            $guard->shouldReceive('user')->andReturn($mockUser);

            $view = $this->factory;
            $view->shouldReceive('make')->andReturn($view);
            $view->shouldReceive('render')->andReturn('widget error occur!');

            $fakeWidgetRenderString = $widgetHandler->render('testWidgetId', []);

            $this->assertEquals('widget error occur!', $fakeWidgetRenderString);
        }

        /**
         * testRenderExceptionOccurOnGuest
         *
         * @return void
         */
        public function testRenderExceptionOccurOnGuest()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn(null);

            $mockUser = m::mock('Xpressengine\User\UserInterface');
            $mockUser->shouldReceive('getRating')->andReturn('guest');

            $guard = $this->guard;
            $guard->shouldReceive('user')->andReturn($mockUser);

            $fakeWidgetRenderString = $widgetHandler->render('testWidgetId', []);

            $this->assertEquals('', $fakeWidgetRenderString);
        }

        /**
         * testSetUp
         *
         * @return void
         */
        public function testSetup()
            {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn($this->fakeWidgetClassName);

            $fakeWidgetSetupString = $widgetHandler->setup('testWidgetId');

            $this->assertEquals('fake Setup String', $fakeWidgetSetupString);

        }

        /**
         * testSetUpFail
         *
         * @return void
         */
        public function testSetUpFail()
        {
            $this->setExpectedException('\XpressEngine\Widget\Exceptions\NotFoundWidgetException');

            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn(null);

            $fakeWidgetSetupString = $widgetHandler->setup('testWidgetId');

        }

        /**
         * testGetAll
         *
         * @return void
         */
        public function testGetAll()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn(['FakeWidget']);

            $fakeWidgets = $widgetHandler->getAll();

            $this->assertEquals(['FakeWidget'], $fakeWidgets);
        }

        /**
         * testGetAllWithFilter
         *
         * @return void
         */
        public function testGetAllWithFilter()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn(['Xpressengine\Tests\Widget\FakeWidget']);

            $filter = function ($widgetClassname) {
                return false;
            };

            $fakeWidgets = $widgetHandler->getAll($filter);

            $this->assertEquals([], $fakeWidgets);
        }

        /**
         * testGetGeneratedCode
         *
         * @return void
         */
        public function testGetGeneratedCode()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $id = 'fakeWidgetId';
            $inputs = [
                'args1' => 'value1',
                'args2' => 'value2',
                'args3' => 'value3',
            ];

            $this->register->shouldReceive('get')->with('widget/'.$id)->andReturn($this->fakeWidgetClassName);
            $resultString = $widgetHandler->generateCode($id, $inputs);

            $expected = "<xewidget>
  <args1>value1</args1>
  <args2>value2</args2>
  <args3>value3</args3>
</xewidget>
";

            $this->assertEquals($expected,
                $resultString);
        }

        /**
         * setUp
         *
         * @return void
         */
        public function setUp()
        {
            $registerMock = m::mock('Xpressengine\Plugin\PluginRegister');
            $guardMock = m::mock('Xpressengine\User\GuardInterface');
            $factoryMock = m::mock('Illuminate\Contracts\View\Factory');

            $this->register = $registerMock;
            $this->guard = $guardMock;
            $this->factory = $factoryMock;
        }
    }


}
