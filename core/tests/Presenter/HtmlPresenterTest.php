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
use Xpressengine\Presenter\Html\HtmlPresenter;

/**
 * HtmlRendererTest
 * @package Xpressengine\Tests\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class HtmlPresenterTest extends TestCase
{
    /**
     * @var m\MockInterface|\Xpressengine\Presenter\Presenter
     */
    protected $presenter;

    /**
     * @var m\MockInterface|\Xpressengine\Seo\SeoHandler
     */
    protected $seo;

    /**
     * @var m\MockInterface|\Xpressengine\Widget\WidgetParser
     */
    protected $widgetParser;

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
        $presenter = m::mock('Xpressengine\Presenter\Presenter');
        $seo = m::mock('Xpressengine\Seo\SeoHandler');
        $widgetParser = m::mock('Xpressengine\Widget\WidgetParser');

        $this->presenter = $presenter;
        $this->seo = $seo;
        $this->widgetParser = $widgetParser;
    }

    /**
     * test renderer
     *
     * @return void
     */
    public function testRenderer()
    {
        $presenter = $this->presenter;
        $seo = $this->seo;
        $widgetParser = $this->widgetParser;

        $renderer = new HtmlPresenter($presenter, $seo, $widgetParser);

        $presenter->shouldReceive('getSkinTargetId')->andReturn('skinTargetId');
        $presenter->shouldReceive('getId')->andReturn('id');
        $presenter->shouldReceive('getIsSettings')->andReturn(true);
        $presenter->shouldReceive('getRenderType')->andReturn(\Xpressengine\Presenter\Presenter::RENDER_ALL);

        $presenter->shouldReceive('getData')->andReturn([
            'key1' => 'value1',
            'key2' => [
                'key2-1' => 'value2-1',
                'key2-2' => 'value2-2',
            ],
        ]);
        $presenter->shouldReceive('getShared')->andReturn([]);

        $renderer->setCommonHtmlWrapper('name');
        $renderer->setPopupHtmlWrapper('name');

        $this->assertEquals('html', $renderer->format());
        $this->assertInstanceOf('Xpressengine\Presenter\Presenter', $renderer->getPresenter());

        $seo->shouldReceive('import');

        $request = m::mock('Illuminate\Http\Request');
        $view = m::mock('Illuminate\View\Factory');
        $theme = m::mock('Xpressengine\Theme\ThemeHandler');
        $skin = m::mock('Xpressengine\Skin\SkinHandler');
        $settings = m::mock('Xpressengine\Settings\SettingsHandler');
        $instanceConfig = m::mock('Xpressengine\Routing\InstanceConfig');

        $instanceConfig->shouldReceive('getInstanceId')->andReturn('a');

        $themeInstance = m::mock('ThemeInstance');
        $themeInstance->shouldReceive('render');

        $request->shouldReceive('isMobile')->andReturn(false);

        $themeViewInstance = m::mock('View', '\Illuminate\View\View');
        $themeViewInstance->shouldReceive('render')->andReturn('themeContent');
        $themeViewInstance->shouldReceive('with')->andReturn('');

        $themeInstance = m::mock('Theme', '\Xpressengine\Theme\ThemeEntity');
        $themeInstance->shouldReceive('render')->andReturn($themeViewInstance);
        $themeInstance->shouldReceive('with')->andReturn('');

        $theme->shouldReceive('getSelectedTheme')->once()->andReturn(null);
        $theme->shouldReceive('selectSiteTheme');
        $theme->shouldReceive('getSelectedTheme')->once()->andReturn($themeInstance);

        $skinInstance = m::mock('SkinInstance');
        $skinInstance->shouldReceive('setView')->andReturn($skinInstance);
        $skinInstance->shouldReceive('setData')->andReturn($skinInstance);
        $skinInstance->shouldReceive('render')->andReturn('content');

        $skin->shouldReceive('getAssignedSettings')->andReturn($skinInstance);

        $viewInstance = m::mock('View', '\Illuminate\View\View');
        $viewInstance->shouldReceive('render')->andReturn('');
        $viewInstance->shouldReceive('with')->andReturn('');

        $view->shouldReceive('make')->andReturn($viewInstance);

        $presenter->shouldReceive('getViewFactory')->andReturn($view);
        $presenter->shouldReceive('getRequest')->andReturn($request);
        $presenter->shouldReceive('getInstanceConfig')->andReturn($instanceConfig);
        $presenter->shouldReceive('getSkinHandler')->andReturn($skin);
        $presenter->shouldReceive('getThemeHandler')->andReturn($theme);
        $presenter->shouldReceive('getViewFactory')->andReturn($view);


        $presenter->shouldReceive('isWidgetParsing')->andReturn(true);
        $widgetParser->shouldReceive('parseXml');

        $renderer->render();
    }
}
