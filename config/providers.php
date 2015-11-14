<?php

return [
    /*
     * Laravel Framework Service Providers...
     */
    Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Routing\ControllerServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    Illuminate\Database\DatabaseServiceProvider::class,
    Illuminate\Encryption\EncryptionServiceProvider::class,
    Illuminate\Filesystem\FilesystemServiceProvider::class,
    Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Mail\MailServiceProvider::class,
    Illuminate\Pagination\PaginationServiceProvider::class,
    Illuminate\Pipeline\PipelineServiceProvider::class,
    Illuminate\Queue\QueueServiceProvider::class,
    Illuminate\Redis\RedisServiceProvider::class,
    //        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    Illuminate\Translation\TranslationServiceProvider::class,
    Illuminate\Validation\ValidationServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class,

    Jenssegers\Agent\AgentServiceProvider::class,

    /*
     * Application Service Providers...
     */
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\MobileServiceProvider::class,
    App\Providers\HttpServiceProvider::class,

    App\Providers\InterceptionServiceProvider::class,
    App\Providers\PluginServiceProvider::class,
    App\Providers\UIObjectServiceProvider::class,
    App\Providers\ThemeServiceProvider::class,
    App\Providers\SkinServiceProvider::class,
    App\Providers\SettingsServiceProvider::class,
    App\Providers\RegisterServiceProvider::class,

    App\Providers\RoutingServiceProvider::class,
    App\Providers\MenuServiceProvider::class,
    App\Providers\ModuleServiceProvider::class,
    App\Providers\ConfigServiceProvider::class,
    App\Providers\DocumentServiceProvider::class,
    App\Providers\DatabaseServiceProvider::class,
    App\Providers\DynamicFieldServiceProvider::class,
    App\Providers\KeygenServiceProvider::class,

    App\Providers\MemberServiceProvider::class,
    App\Providers\StorageServiceProvider::class,
    App\Providers\MediaServiceProvider::class,
    App\Providers\PermissionServiceProvider::class,
    App\Providers\CommentServiceProvider::class,

    App\Providers\PresenterServiceProvider::class,

    App\Providers\CategoryServiceProvider::class,
    App\Providers\CaptchaServiceProvider::class,
    App\Providers\WidgetServiceProvider::class,

    App\Providers\CounterServiceProvider::class,
    App\Providers\TagServiceProvider::class,

    App\Providers\ToggleMenuServiceProvider::class,
    App\Providers\TemporaryServiceProvider::class,

    App\Providers\TrashServiceProvider::class,

    App\Providers\TranslationServiceProvider::class,

    App\Providers\SeoServiceProvider::class,

    App\Providers\SiteServiceProvider::class,

    App\Providers\PurifierServiceProvider::class,

    /*
     * for develop, remove it before first release
     * */
    //Barryvdh\Debugbar\ServiceProvider::class, // debugbar
    //Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class // ide_helper
];
