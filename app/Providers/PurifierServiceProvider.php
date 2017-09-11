<?php
namespace App\Providers;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\ServiceProvider;

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
