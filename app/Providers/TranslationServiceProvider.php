<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Translation\Loaders\LangFileLoader;
use Xpressengine\Translation\Loaders\LangURLLoader;
use Xpressengine\Translation\TransCache;
use Xpressengine\Translation\TransCachedDatabase;
use Xpressengine\Translation\Translator;

class TranslationServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->app['events']->listen('locale.changed', function($locale) {
            $this->app['xe.translator']->setLocale($locale);
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
    }

    public function register()
    {
        $this->app->singleton(['xe.translator' => Translator::class], function ($app) {
            $debug = $app['config']['app.debug'];
            $keyGen = $app['xe.keygen'];
            $cache = new TransCache($app['cache']->driver(), $debug);
            $conn = $app['xe.db']->connection();
            $db = new TransCachedDatabase($cache, $conn);
            $fileLoader = new LangFileLoader($app['files']);
            $urlLoader = new LangURLLoader();

            $trans = new Translator($app['config']['xe.lang'], $keyGen, $db, $fileLoader, $urlLoader);
            return $trans;
        });
    }

    public function provides()
    {
        return ['xe.translator'];
    }
}
