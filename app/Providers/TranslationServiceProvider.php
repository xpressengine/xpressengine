<?php
/**
 * TranslationServiceProvider.php
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

use Blade;
use Illuminate\Foundation\Events\LocaleUpdated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;
use Xpressengine\Translation\Loaders\LangFileLoader;
use Xpressengine\Translation\Loaders\LangURLLoader;
use Xpressengine\Translation\TransCache;
use Xpressengine\Translation\TransCachedDatabase;
use Xpressengine\Translation\Translator;

/**
 * Class TranslationServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->extendBlade();

        $this->app['events']->listen(LocaleUpdated::class, function($event) {
            $this->app['xe.translator']->setLocale($event->locale);
        });

        $this->app['validator']->extend('LangRequired', function ($attribute, $value) {
            $fields = $this->app['request']->all();
            $protocol = 'xe_lang_preprocessor://';
            $prefix = null;
            foreach ($fields as $key => $val) {
                if (starts_with($key, $protocol)) {
                    if ($val == $attribute) {
                        $prefix = substr($key, 0, strrpos($key, '/'));
                        break;
                    }
                }
            }

            $locale = $this->app['xe.translator']->getLocale();
            $name = $prefix . '/locale/' . $locale;
            $validator = null;

            foreach ($fields as $key => $val) {
                if ($name == $key) {
                    $validator = $this->app['validator']->make(
                        [$attribute => $val],
                        [$attribute => 'Required']
                    );
                }
            }

            if ($validator === null) {
                return false;
            }

            return $validator->passes();
        }, 'The :attribute field is required.');
        $this->app['validator']->replacer(
            'LangRequired',
            function ($message, $attribute, $rule, $parameters, $validator) {
                return xe_trans('validation.required', [
                    'attribute' => $validator->getDisplayableAttribute($attribute)
                ]);
            }
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Translator::class, function ($app) {
            $db = new TransCachedDatabase($app['xe.db']->connection());
            $cache = new TransCache($app['cache']->driver(), $db);
            $fileLoader = new LangFileLoader($app['files']);
            $urlLoader = new LangURLLoader();

            return new Translator($app['config']['xe.lang'], $app['xe.keygen'], $cache, $fileLoader, $urlLoader);
        });
        $this->app->alias(Translator::class, 'xe.translator');

        $this->app->resolving('validator', function ($instance, $app) {
            $instance->resolver(function ($translator, $data, $rules, $messages, $customAttributes) use ($app) {
                return new Validator($app['xe.translator'], $data, $rules, $messages, $customAttributes);
            });
        });
    }

    public function provides()
    {
        return ['xe.translator'];
    }

    /**
     * extendBlade
     *
     * @return void
     */
    protected function extendBlade()
    {
        Blade::directive(
            'expose_trans',
            function ($expression) {
                return "<?php expose_trans($expression); ?>";
            }
        );
    }
}
