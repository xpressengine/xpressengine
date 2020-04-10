<?php
/**
 * DynamicFieldServiceProvider.php
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

use App\FieldTypes\Email;
use App\FieldTypes\Textarea;
use App\FieldTypes\Url;
use Illuminate\Support\ServiceProvider;
use App;
use Xpressengine\DynamicField\ConfigHandler;
use Xpressengine\DynamicField\DatabaseProxy;
use Xpressengine\DynamicField\DynamicFieldHandler;
use Xpressengine\DynamicField\RegisterHandler;
use App\FieldTypes\Category;
use App\FieldTypes\Number;
use App\FieldTypes\Text;
use App\FieldTypes\Boolean;
use App\FieldTypes\Address;
use App\FieldTypes\CellPhoneNumber;
use App\FieldSkins\Category\DefaultSkin as CategoryDefault;
use App\FieldSkins\Category\CategoryRadioSkin;
use App\FieldSkins\Number\DefaultSkin as NumberDefault;
use App\FieldSkins\Text\DefaultSkin as TextDefault;
use App\FieldSkins\Text\EmailSkin as TextEmail;
use App\FieldSkins\Text\UrlSkin as TextUrl;
use App\FieldSkins\Boolean\DefaultSkin as BooleanDefault;
use App\FieldSkins\Address\DefaultSkin as AddressDefault;
use App\FieldSkins\CellPhoneNumber\DefaultSkin as CellPhoneNumberDefault;
use App\FieldSkins\Textarea\DefaultSkin as TextareaDefault;
use App\FieldSkins\Email\DefaultSkin as EmailDefault;
use App\FieldSkins\Url\DefaultSkin as UrlDefault;

/**
 * Class DynamicFieldServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DynamicFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        app('xe.db.proxy')->register(new DatabaseProxy(App::make('xe.dynamicField')));
        $this->registerFieldType();
        $this->registerFieldDefaultSkin();
        $this->addValidationRule();
    }

    /**
     * Register the dynamic field type.
     *
     * @return void
     */
    private function registerFieldType()
    {
        $registerHandler = app('xe.dynamicField')->getRegisterHandler();

        $registerHandler->add(Category::class);
        $registerHandler->add(Number::class);
        $registerHandler->add(Text::class);
        $registerHandler->add(Boolean::class);
        $registerHandler->add(Address::class);
        $registerHandler->add(CellPhoneNumber::class);
        $registerHandler->add(Textarea::class);
        $registerHandler->add(Email::class);
        $registerHandler->add(Url::class);
    }

    /**
     * Register the dynamic field skin.
     *
     * @return void
     */
    private function registerFieldDefaultSkin()
    {
        $registerHandler = app('xe.dynamicField')->getRegisterHandler();

        $registerHandler->add(CategoryDefault::class);
        $registerHandler->add(CategoryRadioSkin::class);
        $registerHandler->add(NumberDefault::class);
        $registerHandler->add(TextDefault::class);
        $registerHandler->add(TextEmail::class);
        $registerHandler->add(TextUrl::class);
        $registerHandler->add(BooleanDefault::class);
        $registerHandler->add(AddressDefault::class);
        $registerHandler->add(CellPhoneNumberDefault::class);
        $registerHandler->add(TextareaDefault::class);
        $registerHandler->add(EmailDefault::class);
        $registerHandler->add(UrlDefault::class);
    }

    /**
     * Add validation rule.
     *
     * @return void
     */
    private function addValidationRule()
    {
        $this->app['validator']->extend('df_id', function ($attribute, $value) {
            if (! is_string($value) && ! is_numeric($value)) {
                return false;
            }

            return preg_match('/^[a-zA-Z]+([a-zA-Z0-9_]+)?[a-zA-Z0-9]+$/', $value) > 0;
        });
        $this->app['validator']->replacer('df_id', function ($message, $attribute, $rule, $parameters) {
            return xe_trans('xe::validation.df_id', ['attribute' => $attribute]);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('xe.dynamicField', function ($app) {

            /** @var \Xpressengine\Database\VirtualConnectionInterface $connection */
            $connection = $app['xe.db']->connection();
            $proxyClass = $app['xe.interception']->proxy(DynamicFieldHandler::class, 'DynamicField');
            return new $proxyClass(
                $connection,
                new ConfigHandler($connection, $app['xe.config']),
                new RegisterHandler($this->app['xe.pluginRegister'], $this->app['events']),
                $app['view'],
                $app['xe.pluginRegister']
            );
        });
    }
}
