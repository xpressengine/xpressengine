<?php
/**
 * web.php
 *
 * PHP version 7
 *
 * @category    Routes
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::settings(
    '/',
    function () {
        Route::get('/', ['as' => 'settings', 'uses' => 'DashboardController@redirect']);
    }
);

Route::settings(
    'dashboard',
    function () {
        Route::get(
            '/',
            ['as' => 'settings.dashboard', 'uses' => 'DashboardController@index', 'settings_menu' => ['dashboard.home']]
        );
    }
);

Route::settings('lang', function () {
    Route::put('save', ['as' => 'settings.lang.save', 'uses' => 'LangController@save']);
    Route::get('/', [
        'as' => 'settings.lang.index',
        'uses' => 'LangController@index',
        'settings_menu' => ['setting.lang']
    ]);

    Route::get('import', ['as' => 'settings.lang.import', 'uses' => 'LangController@getImport']);
    Route::post('import', ['as' => 'settings.lang.import', 'uses' => 'LangController@import']);
});

Route::group(
    ['prefix' => 'lang'],
    function() {
        Route::get('lines/many', ['as' => 'lang.lines.many', 'uses' => 'LangController@getLinesMany']);
        Route::get('lines/{key}', ['as' => 'lang.lines.key', 'uses' => 'LangController@getLinesWithKey']);
        Route::get('search/{locale}', ['as' => 'lang.search', 'uses' => 'LangController@searchKeyword']);
    }
);

/* user */

/*
 * user/auth
 * */
Route::group(
    ['prefix' => 'auth'],
    function () {
        // login
        Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
        Route::post('login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);

        // register
        Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@getRegister']); // for select method to confirm user
        Route::post('term_agree', ['as' => 'auth.register.term_agree', 'uses' => 'Auth\RegisterController@postTermAgree']);

        //deprecated 회원 가입 전 이메일 인증 기능 삭제됨
        Route::post('register/confirm', ['as' => 'auth.register.confirm', 'uses' => 'Auth\RegisterController@postRegisterConfirm']); // 인증 이메일 입력, 인증 코드 입력

        // Route::get('register/create', ['as' => 'auth.register.create', 'uses' => 'Auth\RegisterController@getRegisterForm']); // for create form
        Route::post('register', ['as' => 'auth.register.store', 'uses' => 'Auth\RegisterController@postRegister']); // for store

        //pending_email approve
        Route::post('send_approve_email', ['as' => 'auth.send_approve_email', 'uses' => 'Auth\RegisterController@getSendApproveEmail']);
        Route::get('approve_email', ['as' => 'auth.approve_email', 'uses' => 'Auth\RegisterController@postApproveEmail']);

        Route::get('register/add', ['as' => 'auth.register.add', 'uses' => 'Auth\RegisterController@getRegisterAddInfo']);
        Route::post('register/add', ['as' => 'auth.register.add', 'uses' => 'Auth\RegisterController@postRegisterAddInfo']);

        Route::post('register/check/email', ['as' => 'auth.register.check.email', 'uses' => 'Auth\RegisterController@validateEmail']);
        Route::post('register/check/name', ['as' => 'auth.register.check.name', 'uses' => 'Auth\RegisterController@validateDisplayName']);

        // email confirm
        Route::get('confirm', ['as' => 'auth.confirm', 'uses' => 'Auth\AuthController@getConfirm']); // confirm email

        // logout
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

        // password reset request
        Route::get('reset', ['as' => 'auth.reset', 'uses' => 'Auth\PasswordController@getReset']);
        Route::post('reset', ['as' => 'auth.reset', 'uses' => 'Auth\PasswordController@postReset']);

        // password reset
        Route::get('password', ['as' => 'auth.password', 'uses' => 'Auth\PasswordController@getPassword']);
        Route::post('password', ['as' => 'auth.password', 'uses' => 'Auth\PasswordController@postPassword']);

        // terms
        Route::get('terms/{id}', ['as' => 'auth.terms', 'uses' => 'Auth\AuthController@terms']);

        // admin auth
        Route::get('admin', ['as' => 'auth.admin', 'uses' => 'Auth\AuthController@getAdminAuth']);
        Route::post('admin', ['as' => 'auth.admin', 'uses' => 'Auth\AuthController@postAdminAuth']);

        // pending user
        Route::get('/pending_admin', ['as' => 'auth.pending_admin', 'uses' => 'Auth\AuthController@pendingAdmin']);
        Route::get('/pending_email', ['as' => 'auth.pending_email', 'uses' => 'Auth\AuthController@pendingEmail']);
    }
);

/*
 * user/profile
 * */
Route::group(
    ['prefix' => '@{user}'],
    function () {
        // profile
        Route::get('/', ['as' => 'user.profile', 'uses' => 'User\ProfileController@index']);
        Route::post('/', ['as' => 'user.profile.update', 'uses' => 'User\ProfileController@update']);
    }
);

/*
 * user settings
 * */
Route::group(
    ['prefix' => 'user'],
    function () {

        Route::get('/{section?}', ['as' => 'user.settings', 'uses' => 'User\UserController@show']);

        // settings secton
        Route::group(
            ['prefix' => 'settings'],
            function () {
                Route::group(
                    ['prefix' => 'name'],
                    function () {
                        Route::post(
                            '/',
                            [
                                'as' => 'user.settings.name.update',
                                'uses' => 'User\UserController@updateDisplayName'
                            ]
                        );

                        // check name exists
                        Route::post(
                            'check',
                            [
                                'as' => 'user.settings.name.check',
                                'uses' => 'User\UserController@validateDisplayName'
                            ]
                        );
                    }
                );

                Route::group(
                    ['prefix' => 'password'],
                    function () {
                        Route::post(
                            '/',
                            [
                                'as' => 'user.settings.password.update',
                                'uses' => 'User\UserController@updatePassword'
                            ]
                        );
                        // check password is valid
                        Route::post(
                            'check',
                            [
                                'as' => 'user.settings.password.check',
                                'uses' => 'User\UserController@validatePassword'
                            ]
                        );
                    }
                );

                // mail action at edit
                Route::group(
                    ['prefix' => 'mail'],
                    function () {
                        Route::get(
                            'list',
                            ['as' => 'user.settings.mail.list', 'uses' => 'User\UserController@getMailList']
                        );
                        Route::post(
                            'add',
                            ['as' => 'user.settings.mail.add', 'uses' => 'User\UserController@addMail']
                        );
                        Route::post(
                            'update',
                            ['as' => 'user.settings.mail.update', 'uses' => 'User\UserController@updateMainMail']
                        );
                        Route::post(
                            'confirm',
                            ['as' => 'user.settings.mail.confirm', 'uses' => 'User\UserController@confirmMail']
                        );
                        Route::post(
                            'delete',
                            ['as' => 'user.settings.mail.delete', 'uses' => 'User\UserController@deleteMail']
                        );
                    }
                );

                Route::group(
                    ['prefix' => 'pending_mail'],
                    function () {
                        Route::post(
                            'delete',
                            [
                                'as' => 'user.settings.pending_mail.delete',
                                'uses' => 'User\UserController@deletePendingMail'
                            ]
                        );
                        Route::post(
                            'resend',
                            [
                                'as' => 'user.settings.pending_mail.resend',
                                'uses' => 'User\UserController@resendPendingMail'
                            ]
                        );
                    }
                );

                // addition info action at edit
                Route::group(
                    ['prefix' => 'additions/{field}'],
                    function () {
                        Route::get(
                            '/',
                            ['as' => 'user.settings.additions.show', 'uses' => 'User\UserController@showAdditionField']
                        );
                        Route::get(
                            '/edit',
                            ['as' => 'user.settings.additions.edit', 'uses' => 'User\UserController@editAdditionField']
                        );
                        Route::put(
                            '/',
                            ['as' => 'user.settings.additions.update', 'uses' => 'User\UserController@updateAdditionField']
                        );
                    }
                );

                Route::group(
                    ['prefix' => 'leave'],
                    function () {
                        Route::post(
                            '/',
                            [
                                'as' => 'user.settings.leave',
                                'uses' => 'User\UserController@leave'
                            ]
                        );
                    }
                );
            }
        );
    }
);

/*
 * terms
 * */
Route::get('terms/{id}', ['as' => 'terms', 'uses' => 'User\TermsController@index']);

/*
 * settings/user
 * */
Route::settings(
    'user',
    function () {

        Route::group(['middleware' => ['admin']], function() {
            // index
            Route::get(
                '/',
                [
                    'as' => 'settings.user.index',
                    'uses' => 'User\Settings\UserController@index',
                    'settings_menu' => 'user.list',
                    'permission' => 'user.list'
                ]
            );

            // create
            Route::get(
                'create',
                [
                    'as' => 'settings.user.create',
                    'uses' => 'User\Settings\UserController@create',
                    'settings_menu' => 'user.create'
                ]
            );

            Route::post(
                '/',
                ['as' => 'settings.user.store', 'uses' => 'User\Settings\UserController@store']
            );

            // mail action at edit
            Route::get(
                'mail/list',
                ['as' => 'settings.user.mail.list', 'uses' => 'User\Settings\UserController@getMailList']
            );
            Route::post(
                'mail/add',
                ['as' => 'settings.user.mail.add', 'uses' => 'User\Settings\UserController@postAddMail']
            );
            Route::post(
                'mail/delete',
                ['as' => 'settings.user.mail.delete', 'uses' => 'User\Settings\UserController@postDeleteMail']
            );
            Route::post(
                'mail/confirm',
                ['as' => 'settings.user.mail.confirm', 'uses' => 'User\Settings\UserController@postConfirmMail']
            );

            // page to delete users
            Route::get(
                'delete',
                ['as' => 'settings.user.delete', 'uses' => 'User\Settings\UserController@deletePage']
            );

            // delete users
            Route::delete(
                '/',
                ['as' => 'settings.user.destroy', 'uses' => 'User\Settings\UserController@destroy']
            );
            Route::get(
                '{id}/edit',
                [
                    'as' => 'settings.user.edit',
                    'uses' => 'User\Settings\UserController@edit',
                    'settings_menu' => 'user.edit',
                    'permission' => 'user.edit',

                ]
            );
            // update user
            Route::put('{id}', ['as' => 'settings.user.update', 'uses' => 'User\Settings\UserController@update']);
        });

        // setting
        Route::group(
            ['prefix' => 'setting'],
            function () {
                Route::group(['prefix' => 'terms', 'settings_menu' => 'setting.terms'], function () {
                    Route::get('create', [
                        'as' => 'settings.user.setting.terms.create',
                        'uses' => 'User\Settings\TermsController@create'
                    ]);
                    Route::post('/', [
                        'as' => 'settings.user.setting.terms.store',
                        'uses' => 'User\Settings\TermsController@store'
                    ]);
                    Route::get('{id}/edit', [
                        'as' => 'settings.user.setting.terms.edit',
                        'uses' => 'User\Settings\TermsController@edit'
                    ]);
                    Route::put('{id}', [
                        'as' => 'settings.user.setting.terms.update',
                        'uses' => 'User\Settings\TermsController@update'
                    ]);
                    Route::delete('/', [
                        'as' => 'settings.user.setting.terms.destroies',
                        'uses' => 'User\Settings\TermsController@destroies'
                    ]);
                    Route::post('enable', [
                        'as' => 'settings.user.setting.terms.enable',
                        'uses' => 'User\Settings\TermsController@enable'
                    ]);

                    Route::get('/', [
                        'as' => 'settings.user.setting.terms.index',
                        'uses' => 'User\Settings\TermsController@index',
                    ]);
                });

                //TODO 컨트롤러 역할 정리 필요
                Route::get('skin', [
                    'as' => 'settings.user.setting.skin',
                    'uses' => 'User\Settings\SettingController@editSkin',
                    'settings_menu' => 'theme.globalSkin',
                ]);
                Route::get('togglemenu', [
                    'as' => 'settings.user.setting.menu',
                    'uses' => 'User\Settings\SettingController@editToggleMenu',
                    'settings_menu' => 'user.menu',
                ]);
            }
        );

        Route::get('search/{keyword?}', [
            'as' => 'settings.user.search', 'uses' => 'User\Settings\UserController@search'
        ]);
    }
);

/*
 * user group
 * */
Route::settings(
    'group',
    function () {

        Route::get(
            'searchGroup/{keyword?}',
            ['as' => 'manage.group.search', 'uses' => 'User\Settings\GroupController@search']
        );

        // list
        Route::get(
            '/',
            [
                'as' => 'manage.group.index',
                'uses' => 'User\Settings\GroupController@index',
                'settings_menu' => ['user.group']
            ]
        );

        // create
        Route::get('create', ['as' => 'manage.group.create', 'uses' => 'User\Settings\GroupController@create', 'settings_menu' => ['user.group.create']]);
        Route::post('create', ['as' => 'manage.group.create', 'uses' => 'User\Settings\GroupController@store']);

        // edit
        Route::get(
            '{id}/edit',
            [
                'as' => 'manage.group.edit',
                'uses' => 'User\Settings\GroupController@edit',
                'settings_menu' => ['user.group.edit']
            ]
        )->where('id', '[0-9a-z\-]+');
        Route::post('{id}/edit', ['as' => 'manage.group.edit', 'uses' => 'User\Settings\GroupController@update'])
            ->where('id', '[0-9a-z\-]+');

        Route::post('update/join', ['as' => 'manage.group.update.join', 'uses' => 'User\Settings\GroupController@updateJoinGroup'])
            ->where('id', '[0-9a-z\-]+');

        // delete
        Route::delete(
            'destroy',
            ['as' => 'manage.group.destroy', 'uses' => 'User\Settings\GroupController@destroy']
        );
    }
);

/* setting */
Route::settings('setting', function () {
    Route::get('/', [
        'as' => 'settings.setting.edit',
        'uses' => 'SettingsController@editSetting',
        'settings_menu' => ['setting.default']
    ]);
    Route::post('store', ['as' => 'settings.setting.update', 'uses' => 'SettingsController@updateSetting']);

    Route::get('permissions', [
        'as' => 'settings.setting.permissions',
        'uses' => 'SettingsController@editPermissions',
        'settings_menu' => ['setting.permission']
    ]);

    Route::post('permissions/{permissionId}', [
        'as' => 'settings.setting.update.permission',
        'uses' => 'SettingsController@updatePermission'
    ]);

    Route::get('logs', [
        'as' => 'settings.setting.log.index',
        'uses' => 'SettingsController@indexLog',
        'settings_menu' => 'setting.admin-log',
        'middleware' => 'admin'
    ]);

    Route::get('saveLog', [
        'as' => 'settings.setting.log.save',
        'uses' => 'SettingsController@saveLog',
        'middleware' => 'admin'
    ]);

    Route::get('logs/{id}', [
        'as' => 'settings.setting.log.show',
        'uses' => 'SettingsController@showLog',
        'middleware' => 'admin'
    ]);

    Route::get('cache/clear', [
        'as' => 'settings.setting.cache.clear',
        'uses' => 'SettingsController@cacheClear',
        'middleware' => 'admin'
    ]);

    Route::get('/admin', [
        'as' => 'settings.auth.admin',
        'uses' => 'SettingsController@getAdminAuth',
    ]);

    Route::post('/admin', [
        'as' => 'settings.auth.admin',
        'uses' => 'SettingsController@postAdminAuth'
    ]);

    //TOGETHER 호환성 문제로 유지
    //@deprecated
    Route::get('theme', [
        'as' => 'settings.setting.theme',
        'uses' => 'Plugin\ThemeSettingsController@editSetting',
        'settings_menu' => 'theme.setting'
    ]);
});

Route::settings(
    'menu',
    function () {

        Route::get(
            '/',
            [
                'as' => 'settings.menu.index',
                'uses' => 'MenuController@index',
                'settings_menu' => ['sitemap.default'],
            ]
        );

        // ajax 로 전체 menu list 가져오기
        Route::get('list', ['as' => 'settings.menu.list', 'uses' => 'MenuController@menuList']);

        // ajax 로 move Item
        Route::put('moveItem', ['as' => 'settings.menu.move.item', 'uses' => 'MenuController@moveItem']);

        // ajax 로 home 으로 지정
        Route::put('setHome', ['as' => 'settings.menu.setHome.item', 'uses' => 'MenuController@setHome']);


        Route::get('menus', ['as' => 'settings.menu.create.menu', 'uses' => 'MenuController@create']);
        Route::post('menus', ['as' => 'settings.menu.store.menu', 'uses' => 'MenuController@store']);

        Route::get('menus/{menuId}', ['as' => 'settings.menu.edit.menu', 'uses' => 'MenuController@edit']);
        Route::put('menus/{menuId}', ['as' => 'settings.menu.update.menu', 'uses' => 'MenuController@update']);

        Route::get('menus/{menuId}/permit', ['as' => 'settings.menu.permit.menu', 'uses' => 'MenuController@permit']);
        Route::delete('menus/{menuId}', ['as' => 'settings.menu.delete.menu', 'uses' => 'MenuController@destroy']);

        Route::get(
            'menus/{menuId}/permission',
            ['as' => 'settings.menu.edit.permission.menu', 'uses' => 'MenuController@editMenuPermission']
        );
        Route::put(
            'menus/{menuId}/permission',
            ['as' => 'settings.menu.update.permission.menu', 'uses' => 'MenuController@updateMenuPermission']
        );

        Route::get(
            'menus/{menuId}/types',
            ['as' => 'settings.menu.select.types', 'uses' => 'MenuController@selectType']
        );
        Route::get(
            'menus/{menuId}/items',
            ['as' => 'settings.menu.create.item', 'uses' => 'MenuController@createItem']
        );
        Route::post(
            'menus/{menuId}/items',
            ['as' => 'settings.menu.store.item', 'uses' => 'MenuController@storeItem']
        );
        Route::get(
            'menus/{menuId}/items/{itemId}',
            ['as' => 'settings.menu.edit.item', 'uses' => 'MenuController@editItem']
        );
        Route::put(
            'menus/{menuId}/items/{itemId}',
            ['as' => 'settings.menu.update.item', 'uses' => 'MenuController@updateItem']
        );

        Route::get(
            'menus/{menuId}/items/{itemId}/permit',
            ['as' => 'settings.menu.permit.item', 'uses' => 'MenuController@permitItem']
        );
        Route::delete(
            'menus/{menuId}/items/{itemId}',
            ['as' => 'settings.menu.delete.item', 'uses' => 'MenuController@destroyItem']
        );

        Route::get(
            'menus/{menuId}/items/{itemId}/permission',
            ['as' => 'settings.menu.edit.permission.item', 'uses' => 'MenuController@editItemPermission']
        );
        Route::put(
            'menus/{menuId}/items/{itemId}/permission',
            ['as' => 'settings.menu.update.permission.item', 'uses' => 'MenuController@updateItemPermission']
        );
    }
);

/* theme  */
Route::settings(
    'theme',
    function () {
        Route::get('installed', [
            'as' => 'settings.theme.installed',
            'uses' => 'Plugin\ThemeSettingsController@installed',
            'settings_menu' => 'theme.installed'
        ]);

        Route::get('install', [
            'as' => 'settings.theme.install',
            'uses' => 'Plugin\ThemeSettingsController@install',
            'settings_menu' => 'theme.install'
        ]);

        Route::get('test', [
            'as' => 'settings.theme.test',
            'uses' => 'Plugin\ThemeSettingsController@test'
        ]);

        Route::get('setting', [
            'as' => 'settings.edit.theme',
            'uses' => 'Plugin\ThemeSettingsController@editSetting',
            'settings_menu' => 'theme.setting'
        ]);
        Route::post(
            'setting',
            ['as' => 'settings.update.theme', 'uses' => 'Plugin\ThemeSettingsController@updateSetting']
        );

        Route::group(['prefix' => 'config'], function () {
            Route::get('/', ['as' => 'settings.theme.config', 'uses' => 'Plugin\ThemeSettingsController@editConfig']);
            Route::put('/', ['as' => 'settings.theme.config', 'uses' => 'Plugin\ThemeSettingsController@updateConfig']);
            Route::delete(
                '/',
                ['as' => 'settings.theme.config', 'uses' => 'Plugin\ThemeSettingsController@deleteConfig']
            );
            Route::post(
                '/',
                ['as' => 'settings.theme.config', 'uses' => 'Plugin\ThemeSettingsController@createConfig']
            );
        });

        Route::get(
            'set_preview',
            ['as' => 'settings.theme.set_preview', 'uses' => 'Plugin\ThemeSettingsController@setStartPreview']
        );
        Route::get(
            'stop_preview',
            ['as' => 'settings.theme.stop_preview', 'uses' => 'Plugin\ThemeSettingsController@setStopPreview']
        );

        Route::group(
            ['middleware' => ['admin']],
            function () {
                Route::get(
                    'edit',
                    [
                        'as' => 'settings.theme.edit',
                        'uses' => 'Plugin\ThemeSettingsController@edit',
                        'settings_menu' => 'theme.editor',
                    ]
                );
                Route::post('edit', ['as' => 'settings.theme.edit', 'uses' => 'Plugin\ThemeSettingsController@update']);
            }
        );
    }
);

Route::settings('extension', function () {
    Route::get('/installed', [
        'as' => 'settings.extension.installed',
        'uses' => 'Plugin\ExtensionSettingsController@installed',
        'settings_menu' => 'extension.installed']);

    Route::get('/install', [
        'as' => 'settings.extension.install',
        'uses' => 'Plugin\ExtensionSettingsController@install',
        'settings_menu' => 'extension.install']);
});

/* update */
Route::settings('update', function(){

    Route::get('/', [
        'as' => 'settings.coreupdate.show',
        'uses' => 'UpdateController@show',
        'settings_menu' => 'dashboard.updates'
    ]);
    Route::put('/', [
        'as' => 'settings.coreupdate.update',
        'uses' => 'UpdateController@update'
    ]);
});

Route::settings('operation', function(){
    Route::get('/', [
        'as' => 'settings.operation.index',
        'uses' => 'UpdateController@showOperation',
        'settings_menu' => 'dashboard.operation'
    ]);

    Route::get('progress', [
        'as' => 'settings.operation.progress',
        'uses' => 'UpdateController@progress'
    ]);
});

/* plugin  */
Route::settings(
    'plugins',
    function () {
        //@deprecated Together 컨텐츠 호환 위해 유지 필요
        Route::group(['permission' => 'plugin'], function () {
            Route::get(
                '/',
                [
                    'as' => 'settings.plugins',
                    'uses' => 'PluginController@index',
                ]
            );

            Route::group(['prefix'=>'installed'], function () {
                Route::get(
                    '/',
                    [
                        'as' => 'settings.plugins',
                        'uses' => 'PluginController@index',
                    ]
                );
            });
        });

        Route::group(['permission' => 'plugin'], function () {
            Route::group(['prefix' => 'manage'], function () {
                Route::get('delete', [
                    'as' => 'settings.plugins.manage.delete',
                    'uses' => 'Plugin\PluginManageController@getDelete'
                ]);

                Route::post('delete', [
                    'as' => 'settings.plugins.manage.delete',
                    'uses' => 'Plugin\PluginManageController@delete'
                ]);

                Route::post('update', [
                    'as' => 'settings.plugins.manage.update',
                    'uses' => 'Plugin\PluginManageController@download'
                ]);

                Route::get('activate', [
                    'as' => 'settings.plugins.manage.activate',
                    'uses' => 'Plugin\PluginManageController@getActivate'
                ]);

                Route::post('activate', [
                    'as' => 'settings.plugins.manage.activate',
                    'uses' => 'Plugin\PluginManageController@activate'
                ]);

                Route::get('deactivate', [
                    'as' => 'settings.plugins.manage.deactivate',
                    'uses' => 'Plugin\PluginManageController@getDeactivate'
                ]);

                Route::post('deactivate', [
                    'as' => 'settings.plugins.manage.deactivate',
                    'uses' => 'Plugin\PluginManageController@deactivate'
                ]);

                Route::get('upload', [
                    'as' => 'settings.plugins.manage.upload',
                    'uses' => 'Plugin\PluginManageController@getUpload'
                ]);
                Route::post('upload', [
                    'as' => 'settings.plugins.manage.upload',
                    'uses' => 'Plugin\PluginManageController@postUpload'
                ]);

                Route::group(['prefix' => 'make'], function () {
                    Route::get('plugin', [
                        'as' => 'settings.plugins.manage.make.plugin',
                        'uses' => 'Plugin\PluginManageController@getMakePlugin'
                    ]);
                    Route::post('plugin', [
                        'as' => 'settings.plugins.manage.make.plugin',
                        'uses' => 'Plugin\PluginManageController@makePlugin'
                    ]);
                    Route::get('theme', [
                        'as' => 'settings.plugins.manage.make.theme',
                        'uses' => 'Plugin\PluginManageController@getMakeTheme'
                    ]);
                    Route::post('theme', [
                        'as' => 'settings.plugins.manage.make.theme',
                        'uses' => 'Plugin\PluginManageController@makeTheme'
                    ]);
                    Route::get('skin', [
                        'as' => 'settings.plugins.manage.make.skin',
                        'uses' => 'Plugin\PluginManageController@getMakeSkin'
                    ]);
                    Route::post('skin', [
                        'as' => 'settings.plugins.manage.make.skin',
                        'uses' => 'Plugin\PluginManageController@makeSkin'
                    ]);
                });

            });

            Route::group(['prefix' => '{pluginId}'], function () {
                Route::get('/', [
                    'as' => 'settings.plugins.show',
                    'uses' => 'Plugin\PluginManageController@show',
                ]);
                Route::get(
                    'detail',
                    ['as' => 'settings.plugins.detail', 'uses' => 'Plugin\PluginManageController@getDetailPopup']
                );
                Route::put('activate', [
                    'as' => 'settings.plugins.activate',
                    'uses' => 'Plugin\PluginManageController@putActivatePlugin'
                ]);
                Route::put('deactivate', [
                    'as' => 'settings.plugins.deactivate',
                    'uses' => 'Plugin\PluginManageController@putDeactivatePlugin'
                ]);
                Route::put('update', [
                    'as' => 'settings.plugins.update',
                    'uses' => 'Plugin\PluginManageController@putUpdatePlugin'
                ]);
                Route::put('renew', [
                    'as' => 'settings.plugins.renew',
                    'uses' => 'Plugin\PluginManageController@renewPlugin'
                ]);
            });
        });

        //@deprecated since 3.0.4
        Route::group(['permission' => 'plugin'], function () {
            Route::group(['prefix' => 'install'], function () {
                Route::get(
                    'items',
                    [
                        'as' => 'settings.plugins.install.items',
                        'uses' => 'PluginInstallController@items'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'as' => 'settings.plugins.install.index',
                        'uses' => 'PluginInstallController@index',
                    ]
                );
                Route::post(
                    '/',
                    [
                        'as' => 'settings.plugins.install',
                        'uses' => 'PluginController@install'
                    ]
                );
            });
        });
    }
);

Route::settings('category', function () {

    // 이하 신규
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('/', ['as' => 'manage.category.show', 'uses' => 'CategoryController@show']);
        Route::post('item/store', [
            'as' => 'manage.category.edit.item.store',
            'uses' => 'CategoryController@storeItem'
        ]);
        Route::post('item/update', [
            'as' => 'manage.category.edit.item.update',
            'uses' => 'CategoryController@updateItem'
        ]);
        Route::post('item/destroy/{force?}', [
            'as' => 'manage.category.edit.item.destroy',
            'uses' => 'CategoryController@destroyItem'
        ]);
        Route::post('item/move', [
            'as' => 'manage.category.edit.item.move',
            'uses' => 'CategoryController@moveItem'
        ]);
        Route::get('item/roots', [
            'as' => 'manage.category.edit.item.roots',
            'uses' => 'CategoryController@roots'
        ]);
        Route::get('item/children', [
            'as' => 'manage.category.edit.item.children',
            'uses' => 'CategoryController@children'
        ]);
    });
});

Route::group(['prefix' => 'tag'], function () {
    Route::get('autoComplete', ['as' => 'tag.autoComplete', 'uses' => 'TagController@autoComplete']);
});

Route::get('file/{id}', ['as' => 'file.path', 'uses' => 'StorageController@file'])->where('id', '[0-9a-z\-]+');

Route::settings('mediaLibrary', function () {
    Route::get('/', [
        'as' => 'settings.mediaLibrary.index',
        'uses' => 'MediaLibrary\Settings\MediaLibrarySettingsController@index',
        'settings_menu' => 'setting.media_library'
    ]);

    Route::post('/fileSetting', [
        'as' => 'settings.mediaLibrary.storeFileSetting',
        'uses' => 'MediaLibrary\Settings\MediaLibrarySettingsController@storeFileSetting'
    ]);

    Route::post('/containerSetting', [
        'as' => 'settings.mediaLibrary.storeContainerSetting',
        'uses' => 'MediaLibrary\Settings\MediaLibrarySettingsController@storeContrainerSetting'
    ]);

    Route::get('/contents', [
        'as' => 'settings.mediaLibrary.contents',
        'uses' => 'MediaLibrary\Settings\MediaLibrarySettingsController@contents',
        'settings_menu' => 'contents.media_library'
    ]);
});

Route::group(['prefix' => 'media_library'], function () {
    Route::get('/', [
        'as' => 'media_library.index',
        'uses' => 'MediaLibrary\MediaLibraryController@index'
    ]);
    Route::delete('/', [
        'as' => 'media_library.drop',
        'uses' => 'MediaLibrary\MediaLibraryController@drop'
    ]);

    Route::group(['prefix' => 'folder'], function () {
        Route::get('/{folder_id}', [
            'as' => 'media_library.get_folder',
            'uses' => 'MediaLibrary\MediaLibraryController@getFolder'
        ]);
        Route::post('/', [
            'as' => 'media_library.store_folder',
            'uses' => 'MediaLibrary\MediaLibraryController@createFolder'
        ]);
        Route::put('/{folder_id}', [
            'as' => 'media_library.update_folder',
            'uses' => 'MediaLibrary\MediaLibraryController@updateFolder'
        ]);
        Route::post('/{folder_id}/move', [
            'as' => 'media_library.move_folder',
            'uses' => 'MediaLibrary\MediaLibraryController@moveFolder'
        ]);
    });

    Route::group(['prefix' => 'file'], function () {
        Route::get('/{mediaLibraryFileId}', [
            'as' => 'media_library.get_file',
            'uses' => 'MediaLibrary\MediaLibraryController@getFile'
        ]);
        Route::put('/{mediaLibraryFileId}', [
            'as' => 'media_library.update_file',
            'uses' => 'MediaLibrary\MediaLibraryController@updateFile'
        ]);
        Route::post('/{mediaLibraryFileId}/modify', [
            'as' => 'media_library.modify_file',
            'uses' => 'MediaLibrary\MediaLibraryController@modifyFile'
        ]);
        Route::post('/', [
            'as' => 'media_library.upload',
            'uses' => 'MediaLibrary\MediaLibraryController@upload'
        ]);
        Route::post('/move', [
            'as' => 'media_library.move_file',
            'uses' => 'MediaLibrary\MediaLibraryController@moveFile'
        ]);
        Route::get('/{mediaLibraryFileId}/download', [
            'as' => 'media_library.download_file',
            'uses' => 'MediaLibrary\MediaLibraryController@download'
        ]);
    });
});

Route::settings('dynamicField', function () {
    Route::get('/', ['as' => 'manage.dynamicField.index', 'uses' => 'DynamicFieldController@index']);
    Route::get('getSkinOption', ['as' => 'manage.dynamicField.getSkinOption', 'uses' => 'DynamicFieldController@getSkinOption']);
    Route::get('getAdditionalConfigure', ['as' => 'manage.dynamicField.getAdditionalConfigure', 'uses' => 'DynamicFieldController@getAdditionalConfigure']);
    Route::post('store', ['as' => 'manage.dynamicField.store', 'uses' => 'DynamicFieldController@store']);
    Route::get('getEditInfo', ['as' => 'manage.dynamicField.getEditInfo', 'uses' => 'DynamicFieldController@getEditInfo']);
    Route::post('update', ['as' => 'manage.dynamicField.update', 'uses' => 'DynamicFieldController@update']);
    Route::post('destroy', ['as' => 'manage.dynamicField.destroy', 'uses' => 'DynamicFieldController@destroy']);
});

Route::group(['prefix' => 'fieldType'], function () {
    Route::post('/storeCategory', ['as' => 'fieldType.storeCategory', 'uses' => 'FieldTypeController@storeCategory']);
});

Route::group(['prefix' => 'draft'], function () {
    Route::get('/', ['as' => 'draft.index', 'uses' => 'DraftController@index']);
    Route::post('store', ['as' => 'draft.store', 'uses' => 'DraftController@store']);
    Route::post('update/{draftId}', ['as' => 'draft.update', 'uses' => 'DraftController@update'])
        ->where('draftId', '[0-9a-z\-]+');
    Route::post('destroy/{draftId}', ['as' => 'draft.destroy', 'uses' => 'DraftController@destroy'])
        ->where('draftId', '[0-9a-z\-]+');

    Route::post('setAuto', ['as' => 'draft.setAuto', 'uses' => 'DraftController@setAuto']);
    Route::post('destroyAuto', ['as' => 'draft.destroyAuto', 'uses' => 'DraftController@destroyAuto']);
});

Route::settings('widget', function () {
    Route::get('list', ['as' => 'settings.widget.list', 'uses' => 'WidgetController@index']);
    Route::get('skin', ['as' => 'settings.widget.skin', 'uses' => 'WidgetController@skin']);
    Route::get('form', ['as' => 'settings.widget.form', 'uses' => 'WidgetController@form']);
    Route::post('setup', ['as' => 'settings.widget.setup', 'uses' => 'WidgetController@setup']);

    Route::get('render', ['as' => 'settings.widget.render', 'uses' => 'WidgetController@render']);
    Route::post('generate', ['as' => 'settings.widget.generate', 'uses' => 'WidgetController@generate']);
});

/* deprecated */
Route::fixed('toggleMenu', function () {
    Route::get('/', ['as' => 'fixed.toggleMenu', 'uses' => 'ToggleMenuController@get']);
});

Route::get('toggleMenu', ['as' => 'toggleMenu', 'uses' => 'ToggleMenuController@get']);
Route::get('toggleMenuPage', ['as' => 'toggleMenuPage', 'uses' => 'ToggleMenuController@getPage']);

Route::settings('toggleMenu', function () {
    Route::post('setting', ['as' => 'manage.toggleMenu.setting', 'uses' => 'ToggleMenuController@postSetting']);
});

Route::settings('trash', function () {
    Route::get('/', ['as' => 'manage.trash.index', 'uses' => 'TrashController@index']);
    Route::post('/clean', ['as' => 'manage.trash.clean', 'uses' => 'TrashController@clean']);
});

/* skin  */
Route::settings(
    'skin',
    function () {
        Route::get('/section', ['as' => 'settings.skin.section.setting', 'uses' => 'SkinController@getSetting']);
        Route::post('/section', ['as' => 'settings.skin.section.setting', 'uses' => 'SkinController@postSetting']);
        Route::put('/assign', ['as' => 'settings.skin.section.assign', 'uses' => 'SkinController@putAssign']);
    }
);

Route::settings('editor', function () {
    Route::group(['prefix' => 'global', 'settings_menu' => 'setting.editor'], function () {
        Route::get('detail', ['as' => 'settings.editor.global.detail', 'uses' => 'EditorController@getGlobalDetailSetting']);
        Route::post('detail', ['as' => 'settings.editor.global.detail', 'uses' => 'EditorController@postGlobalDetailSetting']);
        Route::get('perm', ['as' => 'settings.editor.global.perm', 'uses' => 'EditorController@getGlobalPermSetting']);
        Route::post('perm', ['as' => 'settings.editor.global.perm', 'uses' => 'EditorController@postGlobalPermSetting']);
        Route::get('tool', ['as' => 'settings.editor.global.tool', 'uses' => 'EditorController@getGlobalToolSetting']);
        Route::post('tool', ['as' => 'settings.editor.global.tool', 'uses' => 'EditorController@postGlobalToolSetting']);

        Route::get('/', ['as' => 'settings.editor.global.redirect', 'uses' => 'EditorController@redirectGlobalSetting']);
    });
    Route::group(['prefix' => 'setting'], function () {
        Route::post('{instanceId}', ['as' => 'settings.editor.setting', 'uses' => 'EditorController@setting']);
        Route::get('{instanceId}/detail', ['as' => 'settings.editor.setting.detail', 'uses' => 'EditorController@getDetailSetting']);
        Route::post('{instanceId}/detail', ['as' => 'settings.editor.setting.detail', 'uses' => 'EditorController@postDetailSetting']);

        Route::get('{instanceId}/perm', ['as' => 'settings.editor.setting.perm', 'uses' => 'EditorController@getPermSetting']);
        Route::post('{instanceId}/perm', ['as' => 'settings.editor.setting.perm', 'uses' => 'EditorController@postPermSetting']);

        Route::get('{instanceId}/tool', ['as' => 'settings.editor.setting.tool', 'uses' => 'EditorController@getToolSetting']);
        Route::post('{instanceId}/tool', ['as' => 'settings.editor.setting.tool', 'uses' => 'EditorController@postToolSetting']);
    });
});

Route::group(['prefix' => 'editor'], function () {
    Route::post('file/{instanceId}/upload', ['as' => 'editor.file.upload', 'uses' => 'EditorController@fileUpload']);
    Route::get('file/{instanceId}/source/{id?}', ['as' => 'editor.file.source', 'uses' => 'EditorController@fileSource']);
    Route::get('file/{instanceId}/download/{id?}', ['as' => 'editor.file.download', 'uses' => 'EditorController@fileDownload']);
    Route::post('file/{instanceId}/destroy/{id?}', ['as' => 'editor.file.destroy', 'uses' => 'EditorController@fileDestroy']);
    Route::get('hashTag', ['as' => 'editor.hashTag', 'uses' => 'EditorController@hashTag']);
    Route::get('mention', ['as' => 'editor.mention', 'uses' => 'EditorController@mention']);
});

Route::group(['prefix'=>'widgetbox'], function() {

    Route::get('create', ['as' => 'widgetbox.create', 'uses' => 'WidgetBoxController@create']);
    Route::post('/', ['as' => 'widgetbox.store', 'uses' => 'WidgetBoxController@store']);

    Route::get('{id}/edit', ['as' => 'widgetbox.edit', 'uses' => 'WidgetBoxController@edit']);
    Route::put('{id}', ['as' => 'widgetbox.update', 'uses' => 'WidgetBoxController@update']);

    Route::post('{id}/preview', ['as' => 'widgetbox.preview', 'uses' => 'WidgetBoxController@preview']);
    Route::get('{id}/code', ['as' => 'widgetbox.code', 'uses' => 'WidgetBoxController@code']);

    Route::post('{id}/permission', ['as' => 'widgetbox.permission', 'uses' => 'WidgetBoxController@storePermission']);

});

Route::group(['prefix' => 'captcha'], function () {
    Route::get('naver/reissue', ['as' => 'captcha.naver.reissue', 'uses' => 'CaptchaController@naverReissue']);
});

Route::settings('register', function () {
    Route::get('/', [
        'as' => 'settings.register.getSetting',
        'uses' => 'RegisterSettingsController@editSetting',
        'settings_menu' => 'setting.register'
    ]);
    Route::post('/', [
        'as' => 'settings.register.postSetting',
        'uses' => 'RegisterSettingsController@updateSetting'
    ]);
});
