<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category    DyanmicField
 * @package     Xpressengine\DyanmicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use XeRegister;
use Xpressengine\DynamicField\ConfigHandler;
use Xpressengine\DynamicField\DatabaseProxy;
use Xpressengine\DynamicField\DynamicFieldHandler;
use Xpressengine\DynamicField\RegisterHandler;
use Xpressengine\DynamicField\RevisionManager;
use App\FieldTypes\Category;
use App\FieldTypes\Number;
use App\FieldTypes\Text;
use App\FieldTypes\Boolean;
use App\FieldTypes\Address;
use App\FieldTypes\CellPhoneNumber;
use App\FieldSkins\Category\DefaultSkin as CategoryDefault;
use App\FieldSkins\Number\DefaultSkin as NumberDefault;
use App\FieldSkins\Text\DefaultSkin as TextDefault;
use App\FieldSkins\Boolean\DefaultSkin as BooleanDefault;
use App\FieldSkins\Address\DefaultSkin as AddressDefault;
use App\FieldSkins\CellPhoneNumber\DefaultSkin as CellPhoneNumberDefault;

/**
 * laravel service provider
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
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
    }

    /**
     * register field type
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
    }

    private function registerFieldDefaultSkin()
    {
        $registerHandler = app('xe.dynamicField')->getRegisterHandler();

        $registerHandler->add(CategoryDefault::class);
        $registerHandler->add(NumberDefault::class);
        $registerHandler->add(TextDefault::class);
        $registerHandler->add(BooleanDefault::class);
        $registerHandler->add(AddressDefault::class);
        $registerHandler->add(CellPhoneNumberDefault::class);
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
                new RegisterHandler($this->app['xe.pluginRegister']),
                $app['view']
            );
        });

        $this->app->singleton('xe.dynamicField.revision', function ($app) {
            return new RevisionManager($app['xe.dynamicField']);
        });
    }
}
