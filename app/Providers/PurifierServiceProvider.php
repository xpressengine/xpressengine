<?php
/**
 * PurifierServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class PurifierServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PurifierServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('purifier', function ($app) {

            $config = HTMLPurifier_Config::createDefault();
            $config->autoFinalize = $app['config']['purifier.finalize'];

            $config->loadArray(array_merge(
                [
                    'Core.Encoding' => $app['config']['purifier.encoding'],
                    'Cache.SerializerPath' => $app['config']['purifier.cachePath'],
                ],
                $app['config']['purifier.settings.default']
            ));

            return new HTMLPurifier($config);
        });

        $this->app->bind('HTMLPurifier', 'purifier');
    }
}
