<?php
/**
 * UIObjectServiceProvider.php
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
use Xpressengine\UIObject\UIObjectHandler;
use App\UIObjects\Form\Form;
use App\UIObjects\Form\FormCheckbox;
use App\UIObjects\Form\FormRadio;
use App\UIObjects\Form\FormFile;
use App\UIObjects\Form\FormImage;
use App\UIObjects\Form\FormMediaLibraryImage;
use App\UIObjects\Form\FormLangText;
use App\UIObjects\Form\FormLangTextArea;
use App\UIObjects\Form\FormPassword;
use App\UIObjects\Form\FormSelect;
use App\UIObjects\Form\FormText;
use App\UIObjects\Form\FormTextArea;
use App\UIObjects\Form\FormColorpicker;
use App\UIObjects\Lang\LangText;
use App\UIObjects\Lang\LangTextArea;
use App\UIObjects\User\ProfileBgImage;
use App\UIObjects\User\ProfileImage;

/**
 * UIObjectServiceProvider.php
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UIObjectServiceProvider extends ServiceProvider
{
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

        $this->app->resolving('xe.pluginRegister', function ($register) {
            $this->registerBaseUIObject($register);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register UI Objects.
     *
     * @return void
     */
    protected function registerBaseUIObject($register)
    {
        $register->add(Form::class);
        $register->add(FormText::class);
        $register->add(FormPassword::class);
        $register->add(FormTextArea::class);
        $register->add(FormSelect::class);
        $register->add(FormCheckbox::class);
        $register->add(FormRadio::class);
        $register->add(FormImage::class);
        $register->add(FormMediaLibraryImage::class);
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
