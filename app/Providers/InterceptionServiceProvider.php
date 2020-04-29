<?php
/**
 * InterceptionServiceProvider.php
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

use Illuminate\Support\ServiceProvider;
use Xpressengine\Interception\AdvisorCollection;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Interception\Proxy\Loader\FileLoader;
use Xpressengine\Interception\Proxy\Pass\ClassPass;
use Xpressengine\Interception\Proxy\Pass\MethodDefinitionPass;
use Xpressengine\Interception\Proxy\ProxyGenerator;

/**
 * Class InterceptionServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class InterceptionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InterceptionHandler::class, function ($app) {
            $advisorCollection = new AdvisorCollection();

            $loader = new FileLoader($app['path.proxies'], $app['config']->get('app.debug') === true);
            //$loader = new EvalLoader();
            $passes = [new ClassPass(), new MethodDefinitionPass()];

            $generator = new ProxyGenerator($loader, $passes);

            $interceptionHandler = new InterceptionHandler($advisorCollection, $generator);
            return $interceptionHandler;
        });
        $this->app->alias(InterceptionHandler::class, 'xe.interception');
    }
}
