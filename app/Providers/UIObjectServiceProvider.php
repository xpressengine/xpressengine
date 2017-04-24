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
use App\UIObjects\Form\Form;
use App\UIObjects\Form\FormCheckbox;
use App\UIObjects\Form\FormFile;
use App\UIObjects\Form\FormImage;
use App\UIObjects\Form\FormLangText;
use App\UIObjects\Form\FormLangTextArea;
use App\UIObjects\Form\FormPassword;
use App\UIObjects\Form\FormSelect;
use App\UIObjects\Form\FormText;
use App\UIObjects\Form\FormTextArea;
use App\UIObjects\Form\FormColorpicker;
use App\UIObjects\Lang\LangText;
use App\UIObjects\Lang\LangTextArea;
use App\UIObjects\Member\ProfileBgImage;
use App\UIObjects\Member\ProfileImage;

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
        $register->add(FormColorpicker::class);

        $register->add(ProfileImage::class);
        $register->add(ProfileBgImage::class);

        $register->add(LangText::class);
        $register->add(LangTextArea::class);

        $register->add(FormLangText::class);
        $register->add(FormLangTextArea::class);
    }
}
