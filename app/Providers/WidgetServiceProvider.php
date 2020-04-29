<?php
/**
 * WidgetServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use App\Skins\Widget\ContentInfoSkin;
use App\Skins\Widget\DownloadRankSkin;
use App\Skins\Widget\HtmlWidgetSkin;
use App\Skins\Widget\StorageSpaceSkin;
use App\Skins\Widget\SystemInfoSkin;
use App\Skins\Widget\MenuPrintSkin;
use App\UIObjects\Widget\WidgetGenerator;
use App\UIObjects\Widget\WidgetBox as WidgetBoxUIObject;
use App\Widgets\ContentInfo;
use App\Widgets\DownloadRank;
use App\Widgets\HtmlWidget;
use App\Widgets\StorageSpace;
use App\Widgets\SystemInfo;
use App\Widgets\MenuPrint;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Widget\Models\WidgetBox;
use Xpressengine\Widget\Presenters\AbstractPresenter;
use Xpressengine\Widget\Presenters\BootstrapPresenter;
use Xpressengine\Widget\Presenters\XEUIPresenter;
use Xpressengine\Widget\WidgetBoxHandler;
use Xpressengine\Widget\WidgetBoxRepository;
use Xpressengine\Widget\WidgetHandler;
use Xpressengine\Widget\WidgetParser;

/**
 * Class WidgetServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WidgetHandler::class, function ($app) {
            $proxyClass = $app['xe.interception']->proxy(WidgetHandler::class, 'XeWidget');
            $widgetHandler = new $proxyClass(
                $app['xe.pluginRegister'],
                $app['auth']->guard(),
                $app['view'],
                $app['config']->get('app.debug') === true
            );

            return $widgetHandler;
        });
        $this->app->alias(WidgetHandler::class, 'xe.widget');


        $this->app->singleton(WidgetParser::class, function ($app) {
            $handler = $app['xe.widget'];
            return new WidgetParser($handler);
        });
        $this->app->alias(WidgetParser::class, 'xe.widget.parser');

        $this->app->singleton(WidgetBoxHandler::class, function ($app) {
            $proxyClass = $app['xe.interception']->proxy(WidgetBoxHandler::class, 'XeWidgetBox');
            $widgetHandler = new $proxyClass(
                new WidgetBoxRepository,
                $app['xe.permission']
            );
            return $widgetHandler;
        });
        $this->app->alias(WidgetBoxHandler::class, 'xe.widgetbox');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerWidgets();
        $this->registerWidgetSkins();
        $this->registerUIObject();

        WidgetBoxRepository::setModel(WidgetBox::class);

        AbstractPresenter::setWidgetCodeGenerator(function ($widgetId, array $inputs) {
            return $this->app['xe.widget']->generateCode($widgetId, $inputs);
        });

        WidgetBoxHandler::setContainer($this->app['xe.register']);
        WidgetBoxHandler::addPresenter(BootstrapPresenter::class);
        WidgetBoxHandler::addPresenter(XEUIPresenter::class);
    }

    /**
     * Register widgets.
     *
     * @return void
     */
    protected function registerWidgets()
    {
        $register = $this->app['xe.pluginRegister'];
        $register->add(StorageSpace::class);
        $register->add(ContentInfo::class);
        $register->add(SystemInfo::class);
        $register->add(HtmlWidget::class);
        $register->add(DownloadRank::class);
        $register->add(MenuPrint::class);
    }

    /**
     * Register widgets skins.
     *
     * @return void
     */
    protected function registerWidgetSkins()
    {
        $register = $this->app['xe.pluginRegister'];
        $register->add(SystemInfoSkin::class);
        $register->add(ContentInfoSkin::class);
        $register->add(StorageSpaceSkin::class);
        $register->add(HtmlWidgetSkin::class);
        $register->add(DownloadRankSkin::class);
        $register->add(MenuPrintSkin::class);
    }

    /**
     * Register UI objects.
     *
     * @return void
     */
    protected function registerUIObject()
    {
        $registryManager = $this->app['xe.pluginRegister'];
        $registryManager->add(WidgetGenerator::class);

        $registryManager->add(WidgetBoxUIObject::class);
    }
}
