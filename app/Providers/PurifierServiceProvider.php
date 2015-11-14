<?php
namespace App\Providers;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\ServiceProvider;

class PurifierServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     *
     * @return null
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('purifier', function ($app) {

            $config = HTMLPurifier_Config::createDefault();
            $config->loadArray(array_merge(
                [
                    'Core.Encoding' => $app['config']['purifier.encoding'],
                    'Cache.SerializerPath' => $app['config']['purifier.cachePath'],
                ],
                $app['config']['purifier.settings.default']
            ));

            $def = $config->getHTMLDefinition(true);
            $def->addAttribute('span', 'data-download-link', 'Text');
            $def->addAttribute('span', 'contenteditable', 'Text');

            return new HTMLPurifier($config);
        });

        $this->app->bind('HTMLPurifier', 'purifier');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['purifier'];
    }

}
