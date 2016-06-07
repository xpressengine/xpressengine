<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
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
         * @return string
         */
        public function getCodeCreationForm()
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
         * @param array $args to render parameter array
         *
         * @return mixed
         */
        public function render(array $args)
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
         * testCreate
         *
         * @return void
         */
        public function testCreate()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn($this->fakeWidgetClassName);

            $mockUser = m::mock('Xpressengine\User\UserInterface');
            $mockUser->shouldReceive('getRating')->andReturn('super');

            $guard = $this->guard;
            $guard->shouldReceive('user')->andReturn($mockUser);

            $fakeWidgetRenderString = $widgetHandler->create('testWidgetId', []);

            $this->assertEquals('fake Render String', $fakeWidgetRenderString);
        }

        /**
         * testCreateNoGuard
         *
         * @return void
         */
        public function testCreateNoGuard()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn($this->fakeWidgetClassName);

            $mockUser = m::mock('Xpressengine\User\UserInterface');
            $mockUser->shouldReceive('getRating')->andReturn('guest');

            $guard = $this->guard;
            $guard->shouldReceive('user')->andReturn($mockUser);

            $fakeWidgetRenderString = $widgetHandler->create('testWidgetId', []);

            $this->assertEquals('', $fakeWidgetRenderString);
        }

        /**
         * testCreateExceptionOccurOnSuper
         *
         * @return void
         */
        public function testCreateExceptionOccurOnSuper()
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

            $fakeWidgetRenderString = $widgetHandler->create('testWidgetId', []);

            $this->assertEquals('widget error occur!', $fakeWidgetRenderString);
        }

        /**
         * testCreateExceptionOccurOnGuest
         *
         * @return void
         */
        public function testCreateExceptionOccurOnGuest()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn(null);

            $mockUser = m::mock('Xpressengine\User\UserInterface');
            $mockUser->shouldReceive('getRating')->andReturn('guest');

            $guard = $this->guard;
            $guard->shouldReceive('user')->andReturn($mockUser);

            $fakeWidgetRenderString = $widgetHandler->create('testWidgetId', []);

            $this->assertEquals('', $fakeWidgetRenderString);
        }

        /**
         * testSetUp
         *
         * @return void
         */
        public function testSetUp()
        {
            $widgetHandler = new WidgetHandler($this->register, $this->guard, $this->factory, false);

            $register = $this->register;
            $register->shouldReceive('get')->andReturn($this->fakeWidgetClassName);

            $fakeWidgetSetupString = $widgetHandler->setUp('testWidgetId');

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

            $fakeWidgetSetupString = $widgetHandler->setUp('testWidgetId');

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
                return $widgetClassname::codeCreationAble();
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

            $resultString = $widgetHandler->getGeneratedCode($id, $inputs);

            $this->assertEquals("<xewidget id='fakeWidgetId'><param title='args1'>value1</param><param title='args2'>value2</param><param title='args3'>value3</param></xewidget>",
                $resultString);
        }

        /**
         * testShortWidgetId
         *
         * @return void
         */
        public function testShortWidgetId()
        {
            $shortWidgetId = shortWidgetId('widget/xpressengine@testWidgetId');
            $this->assertEquals('xpressengine@testWidgetId', $shortWidgetId);
        }

        /**
         * testFullWidgetId
         *
         * @return void
         */
        public function testFullWidgetId()
        {
            $fullWidgetId1 = fullWidgetId('xpressengine@testWidgetId');
            $fullWidgetId2 = fullWidgetId('widget/xpressengine@testWidgetId');

            $this->assertEquals('widget/xpressengine@testWidgetId', $fullWidgetId1);
            $this->assertEquals('widget/xpressengine@testWidgetId', $fullWidgetId2);
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
