<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Presenter;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Presenter\Presenter;
use Xpressengine\Presenter\Presentable;

/**
 * Class DocumentRepositoryTest
 * @package Xpressengine\Tests\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PresenterTest extends TestCase
{
    /**
     * @var m\MockInterface|\Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var m\MockInterface|\Illuminate\View\Factory
     */
    protected $view;

    /**
     * @var m\MockInterface|\Xpressengine\Theme\ThemeHandler
     */
    protected $theme;

    /**
     * @var m\MockInterface|\Xpressengine\Skin\SkinHandler
     */
    protected $skin;

    /**
     * @var m\MockInterface|\Xpressengine\Settings\SettingsHandler
     */
    protected $settings;

    /**
     * @var m\MockInterface|\Xpressengine\Routing\InstanceConfig
     */
    protected $instanceConfig;

    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * set up
     *
     * @return void
     */
    public function setUp()
    {
        $request = m::mock('Illuminate\Http\Request');
        $view = m::mock('Illuminate\View\Factory');
        $theme = m::mock('Xpressengine\Theme\ThemeHandler');
        $skin = m::mock('Xpressengine\Skin\SkinHandler');
        $settings = m::mock('Xpressengine\Settings\SettingsHandler');
        $instanceConfig = m::mock('Xpressengine\Routing\InstanceConfig');

        $this->request = $request;
        $this->view = $view;
        $this->theme = $theme;
        $this->skin = $skin;
        $this->settings = $settings;
        $this->instanceConfig = $instanceConfig;
    }

    /**
     * invoked method
     *
     * @param mixed  $object     object
     * @param string $methodName method name
     * @param array  $parameters parameters
     * @return mixed
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }


    /**
     * test get property
     *
     * @return void
     */
    public function testGetProperty()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $this->assertInstanceOf('Illuminate\View\Factory', $presenter->getViewFactory());
        $this->assertInstanceOf('Illuminate\Http\Request', $presenter->getRequest());
        $this->assertInstanceOf('Xpressengine\Routing\InstanceConfig', $presenter->getInstanceConfig());
        $this->assertInstanceOf('Xpressengine\Skin\SkinHandler', $presenter->getSkinHandler());
        $this->assertInstanceOf('Xpressengine\Theme\ThemeHandler', $presenter->getThemeHandler());
    }

    /**
     * test register
     *
     * @return void
     */
    public function testRegister()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $presenter->register('html', function () {
        });

        $reflection = new \ReflectionClass(get_class($presenter));
        $property = $reflection->getProperty('presentables');
        $property->setAccessible(true);
        $result = $property->getValue($presenter);

        $this->assertTrue(isset($result['html']));
    }

    /**
     * test set skin target id
     *
     * @return void
     */
    public function testSetSkinTargetId()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $skinTargetId = 'name';
        $presenter->setSkinTargetId($skinTargetId);

        $reflection = new \ReflectionClass(get_class($presenter));
        $property = $reflection->getProperty('skinTargetId');
        $property->setAccessible(true);
        $result = $property->getValue($presenter);

        $this->assertEquals($skinTargetId, $result);
    }

    /**
     * test set settings skin
     *
     * @return void
     */
    public function testSetSettingsSkin()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $skinTargetId = 'name';
        $presenter->setSettingsSkinTargetId($skinTargetId);

        $reflection = new \ReflectionClass(get_class($presenter));
        $property = $reflection->getProperty('skinTargetId');
        $property->setAccessible(true);
        $result = $property->getValue($presenter);

        $this->assertEquals($skinTargetId, $result);
        $this->assertEquals($skinTargetId, $presenter->getSkinTargetId());

        $property = $reflection->getProperty('isSettings');
        $property->setAccessible(true);
        $result = $property->getValue($presenter);
        $this->assertTrue($result);
        $this->assertTrue($presenter->getIsSettings());
    }

    /**
     * test html render partial
     *
     * @return void
     */
    public function testHtmlRenderPartial()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $presenter->htmlRenderPartial(true);

        $reflection = new \ReflectionClass(get_class($presenter));
        $property = $reflection->getProperty('type');
        $property->setAccessible(true);
        $result = $property->getValue($presenter);

        $this->assertEquals(Presenter::RENDER_CONTENT, $result);

        $presenter->htmlRenderPartial(false);
        $result = $property->getValue($presenter);
        $this->assertEquals(Presenter::RENDER_ALL, $result);
    }

    /**
     * test html render popup
     *
     * @return void
     */
    public function testHtmlRenderPopup()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $presenter->htmlRenderPopup(true);

        $reflection = new \ReflectionClass(get_class($presenter));
        $property = $reflection->getProperty('type');
        $property->setAccessible(true);
        $result = $property->getValue($presenter);

        $this->assertEquals(Presenter::RENDER_POPUP, $result);

        $presenter->htmlRenderPopup(false);
        $result = $property->getValue($presenter);
        $this->assertEquals(Presenter::RENDER_ALL, $result);
    }

    /**
     * test html render popup
     *
     * @return void
     */
    public function testShare()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $presenter->share('key', 'value');
        $result = $presenter->getShared();

        $this->assertEquals('value', $result['key']);

        $presenter->share(['key1' => 'value1']);
        $result = $presenter->getShared();
        $this->assertEquals('value1', $result['key1']);
    }

    /**
     * test make
     *
     * @return void
     */
    public function testMake()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = m::mock(
            'Xpressengine\Presenter\Presenter',
            [$view, $request, $theme, $skin, $settings, $instanceConfig]
        )->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $reflection = new \ReflectionClass(get_class($presenter));
        $method = $reflection->getMethod('get');
        $method->setAccessible(true);

        $renderer = m::mock('Renderer', Presentable::class);
        $presenter->shouldReceive('get')->andReturn($renderer);

        $id = 'id';
        $data = ['key' => 'value'];
        $mergeData = ['key1' => 'value1'];


        $result = $presenter->make($id, $data, $mergeData);
        $this->assertInstanceOf('Renderer', $result);
        $this->assertEquals($id, $presenter->getId());

        $result = $presenter->makeApi($data, $mergeData);
        $this->assertInstanceOf('Renderer', $result);

        $result = $presenter->makeAll($id, $data, $mergeData);
        $this->assertInstanceOf('Renderer', $result);
    }

    /**
     * test get
     *
     * @return void
     */
    public function testGet()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $htmlRenderer = m::mock('HtmlRenderer', Presentable::class);
        $presenter->register('html', function ($presenter) use ($htmlRenderer) {
            return new $htmlRenderer($presenter);
        });
        $jsonRenderer = m::mock('JsonRenderer', Presentable::class);
        $presenter->register('json', function ($presenter) use ($jsonRenderer) {
            return new $jsonRenderer($presenter);
        });

        $request->shouldReceive('format')->once()->andReturn('html');
        $result = $this->invokeMethod($presenter, 'get');
        $this->assertInstanceOf('HtmlRenderer', $result);

        $reflection = new \ReflectionClass(get_class($presenter));
        $property = $reflection->getProperty('api');
        $property->setAccessible(true);
        $property->setValue($presenter, true);

        $request->shouldReceive('format')->once()->andReturn('json');
        $result = $this->invokeMethod($presenter, 'get');
        $this->assertInstanceOf('JsonRenderer', $result);
    }

    /**
     * test get not found format
     *
     * @expectedException \Xpressengine\Presenter\Exceptions\NotFoundFormatException
     * @return void
     */
    public function testGetNotFoundFormat()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $request->shouldReceive('format')->once()->andReturn('html');
        $this->invokeMethod($presenter, 'get');
    }


    /**
     * test get invalid renderer
     *
     * @expectedException \Xpressengine\Presenter\Exceptions\InvalidPresenterException
     * @return void
     */
    public function testGetInvalidPresenter()
    {
        $request = $this->request;
        $view = $this->view;
        $theme = $this->theme;
        $skin = $this->skin;
        $settings = $this->settings;
        $instanceConfig = $this->instanceConfig;

        $presenter = new Presenter(
            $view, $request, $theme, $skin, $settings, $instanceConfig
        );

        $htmlPresenter = m::mock('HtmlPresenter');
        $presenter->register('html', function ($presenter) use ($htmlPresenter) {
            return new $htmlPresenter($presenter);
        });

        $request->shouldReceive('format')->once()->andReturn('html');
        $this->invokeMethod($presenter, 'get');
    }
}
