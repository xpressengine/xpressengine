<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\UIObject\UIObjectHandler;
use Xpressengine\UIObjects\Form\Form;
use Xpressengine\UIObjects\Form\FormCheckbox;
use Xpressengine\UIObjects\Form\FormFile;
use Xpressengine\UIObjects\Form\FormImage;
use Xpressengine\UIObjects\Form\FormLangText;
use Xpressengine\UIObjects\Form\FormLangTextArea;
use Xpressengine\UIObjects\Form\FormPassword;
use Xpressengine\UIObjects\Form\FormSelect;
use Xpressengine\UIObjects\Form\FormText;
use Xpressengine\UIObjects\Form\FormTextArea;
use Xpressengine\UIObjects\Lang\LangText;
use Xpressengine\UIObjects\Lang\LangTextArea;
use Xpressengine\UIObjects\Member\ProfileBgImage;
use Xpressengine\UIObjects\Member\ProfileImage;

class UIObjectServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'xe.uiobject',
            function ($app) {

                $aliases = $app['config']->get('xe.uiobject.aliases');

                $uiObjectHandler = $app['xe.interception']->proxy(UIObjectHandler::class, 'UIObejct');
                $uiObjectHandler = new $uiObjectHandler($app['xe.pluginRegister'], $aliases);

                return $uiObjectHandler;
            }
        );
    }

    public function boot()
    {
        $this->registerBaseUIObject();
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * registerBaseUIObject
     *
     * @return void
     */
    protected function registerBaseUIObject()
    {
        // register base uiobjects
        /** @var PluginRegister $register */
        $register = $this->app['xe.pluginRegister'];

        $register->add(Form::class);
        $register->add(FormText::class);
        $register->add(FormPassword::class);
        $register->add(FormTextArea::class);
        $register->add(FormSelect::class);
        $register->add(FormCheckbox::class);
        $register->add(FormImage::class);
        $register->add(FormFile::class);

        $register->add(ProfileImage::class);
        $register->add(ProfileBgImage::class);

        $register->add(LangText::class);
        $register->add(LangTextArea::class);

        $register->add(FormLangText::class);
        $register->add(FormLangTextArea::class);
    }
}
