<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::settings(
    '/',
    function () {
        Route::get(
            '/',
            [
                'as' => 'settings',
                'uses' => function () {
                    return redirect()->route('settings.dashboard');
                }
            ]
        );
    }
);
Route::settings(
    'dashboard',
    function () {
        Route::get(
            '/',
            ['as' => 'settings.dashboard', 'uses' => 'DashboardController@index', 'settings_menu' => ['dashboard']]
        );
    }
);

Route::settings(
    'lang',
    function () {
        Route::get('lines/{key}', ['as' => 'settings.lang.lines.key', 'uses' => 'LangController@getLinesWithKey']);
        Route::get('search/{locale}', ['as' => 'settings.lang.search', 'uses' => 'LangController@searchKeyword']);
        Route::put('save', ['as' => 'settings.lang.save', 'uses' => 'LangController@save']);
        Route::get('/', [
                'as' => 'settings.lang.index',
                'uses' => 'LangController@index',
                'settings_menu' => ['lang.default']
        ]);
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
        Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
        Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@postRegister']);

        // email confirm
        Route::get('confirm', ['as' => 'auth.confirm', 'uses' => 'Auth\AuthController@getConfirm']);

        // logout
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

        // password reset request
        Route::get('reset', ['as' => 'auth.reset', 'uses' => 'Auth\PasswordController@getReset']);
        Route::post('reset', ['as' => 'auth.reset', 'uses' => 'Auth\PasswordController@postReset']);

        // password reset
        Route::get('password', ['as' => 'auth.password', 'uses' => 'Auth\PasswordController@getPassword']);
        Route::post('password', ['as' => 'auth.password', 'uses' => 'Auth\PasswordController@postPassword']);

        // agreement, privacy
        Route::get('agreement', ['as' => 'auth.agreement', 'uses' => 'Auth\AuthController@getAgreement']);
        Route::get('privacy', ['as' => 'auth.privacy', 'uses' => 'Auth\AuthController@getPrivacy']);
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
 * policies for site, user
 * */
Route::group(
    ['prefix' => 'policies'],
    function () {
        // 개인정보 처리 방침
        Route::get('privacy', ['as' => 'policies.privacy', 'uses' => 'User\PolicyController@privacy']);

        // 약관
        Route::group(
            ['prefix' => 'terms'],
            function() {
                // 서비스
                Route::get('service', ['as' => 'policies.terms.service', 'uses' => 'User\PolicyController@service']);
            }
        );


    }
);
/*
 * settings/user
 * */
Route::settings(
    'user',
    function () {

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
        Route::get('create',
                   [
                       'as' => 'settings.user.create',
                       'uses' => 'User\Settings\UserController@create',
                       'settings_menu' => 'user.create'
                   ]
        );
        Route::post(
            'store',
            ['as' => 'settings.user.store', 'uses' => 'User\Settings\UserController@store']
        );

        Route::get(
            '{id}/edit',
            [
                'as' => 'settings.user.edit',
                'uses' => 'User\Settings\UserController@edit',
                'settings_menu' => 'user.edit',
                'permission' => 'user.edit',

            ]
        )->where('id', '[0-9a-z\-]+');

        Route::post('{id}/edit', ['as' => 'settings.user.edit', 'uses' => 'User\Settings\UserController@update'])
            ->where('id', '[0-9a-z\-]+');

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

        // delete
        Route::delete(
            'destroy',
            ['as' => 'settings.user.destroy', 'uses' => 'User\Settings\UserController@deleteUser']
        );

        // setting
        Route::group(
            ['prefix' => 'setting'],
            function () {

                Route::get(
                    '/',
                    [
                        'as' => 'settings.user.setting',
                        'uses' => 'User\Settings\SettingController@editCommon',
                        'settings_menu' => 'user.setting.default',
                    ]
                );
                Route::post(
                    '/',
                    ['as' => 'settings.user.setting', 'uses' => 'User\Settings\SettingController@updateCommon']
                );

                Route::get(
                    'join',
                    [
                        'as' => 'settings.user.setting.join',
                        'uses' => 'User\Settings\SettingController@editJoin',
                        'settings_menu' => 'user.setting.join',
                    ]
                );

                Route::post(
                    'join',
                    [
                        'as' => 'settings.user.setting.join',
                        'uses' => 'User\Settings\SettingController@updateJoin'
                    ]
                );

                Route::get(
                    'skin',
                    [
                        'as' => 'settings.user.setting.skin',
                        'uses' => 'User\Settings\SettingController@editSkin',
                        'settings_menu' => 'user.setting.skin',
                    ]
                );

                Route::get(
                    'field',
                    [
                        'as' => 'settings.user.setting.field',
                        'uses' => 'User\Settings\SettingController@editField',
                        'settings_menu' => 'user.setting.field',
                    ]
                );

                Route::get(
                    'togglemenu',
                    [
                        'as' => 'settings.user.setting.menu',
                        'uses' => 'User\Settings\SettingController@editToggleMenu',
                        'settings_menu' => 'user.setting.menu',
                    ]
                );

            }
        );

        Route::get(
            'search/{keyword?}',
            ['as' => 'settings.user.search', 'uses' => 'User\Settings\UserController@search']
        );
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
Route::settings(
    'setting',
    function () {
        Route::get(
            '/',
            [
                'as' => 'settings.setting.edit',
                'uses' => 'SettingsController@editSetting',
                'settings_menu' => ['setting.default']
            ]
        );
        Route::post('store', ['as' => 'settings.setting.update', 'uses' => 'SettingsController@updateSetting']);

        Route::get(
            'theme',
            [
                'as' => 'settings.setting.theme',
                'uses' => 'SettingsController@editTheme',
                'settings_menu' => ['setting.theme']
            ]
        );
        Route::post('theme', ['as' => 'settings.setting.theme', 'uses' => 'SettingsController@updateTheme']);

        Route::get(
            'permissions',
            [
                'as' => 'settings.setting.permissions',
                'uses' => 'SettingsController@editPermissions',
                'settings_menu' => ['setting.permission']
            ]
        );

        Route::post(
            'permissions/{permissionId}',
            [
                'as' => 'settings.setting.update.permission',
                'uses' => 'SettingsController@updatePermission'
            ]
        );
    }
);

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
        Route::get('edit', ['as' => 'settings.theme.edit', 'uses' => 'ThemeController@edit', 'settings_menu'=>'setting.theme.edit']);
        Route::post('edit', ['as' => 'settings.theme.edit', 'uses' => 'ThemeController@update']);
        Route::put('edit-auth', ['as' => 'settings.theme.edit.auth', 'uses' => 'ThemeController@auth']);


        Route::get('setting', ['as' => 'settings.theme.setting', 'uses' => 'ThemeController@editSetting']);
        Route::put('setting', ['as' => 'settings.theme.setting', 'uses' => 'ThemeController@updateSetting']);
        Route::delete('setting', ['as' => 'settings.theme.setting', 'uses' => 'ThemeController@deleteSetting']);

        Route::post('setting/create', ['as' => 'settings.theme.setting.create', 'uses' => 'ThemeController@createSetting']);
    }
);

/* plugin  */
Route::settings(
    'plugins',
    function () {
        Route::group(['permission' => 'plugin'], function() {

            Route::get(
                '/',
                [
                    'as' => 'settings.plugins',
                    'uses' => 'PluginController@index',
                    'settings_menu' => ['plugin.list']
                ]
            );

            Route::get('operation', [
                'as' => 'settings.plugins.operation',
                'uses' => 'PluginController@getOperation'
            ]);

            Route::delete('operation', [
                'as' => 'settings.plugins.operation.delete',
                'uses' => 'PluginController@deleteOperation'
            ]);

            Route::post(
                '/',
                [
                    'as' => 'settings.plugins.install',
                    'uses' => 'PluginController@install'
                ]
            );

            Route::get(
                '{pluginId}',
                [
                    'as' => 'settings.plugins.show',
                    'uses' => 'PluginController@show',
                    'settings_menu' => ['plugin.list.detail']
                ]
            );

            Route::put(
                '{pluginId}/activate',
                [
                    'as' => 'settings.plugins.activate',
                    'uses' => 'PluginController@putActivatePlugin'
                ]
            );
            Route::put(
                '{pluginId}/deactivate',
                [
                    'as' => 'settings.plugins.deactivate',
                    'uses' => 'PluginController@putDeactivatePlugin'
                ]
            );
            Route::put(
                '{pluginId}/update',
                [
                    'as' => 'settings.plugins.update',
                    'uses' => 'PluginController@putUpdatePlugin'
                ]
            );
            Route::put(
                '{pluginId}/download',
                [
                    'as' => 'settings.plugins.download',
                    'uses' => 'PluginController@putDownloadPlugin'
                ]
            );

            Route::delete(
                '{pluginId}',
                [
                    'as' => 'settings.plugins.delete',
                    'uses' => 'PluginController@delete'
                ]
            );
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
        Route::post('item/destroy', [
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
        Route::post('/assign', ['as' => 'settings.skin.section.assign', 'uses' => 'SkinController@postAssign']);
    }
);

Route::settings(
    'seo',
    function () {
        Route::get(
            'setting',
            [
                'as' => 'manage.seo.edit',
                'uses' => 'SeoController@getSetting',
                'settings_menu' => ['setting.seo'],
            ]
        );
        Route::post(
            'setting',
            [
                'as' => 'manage.seo.update',
                'uses' => 'SeoController@postSetting'
            ]
        );
    }
);

Route::settings('editor', function () {
    Route::post('setting/{instanceId}', ['as' => 'settings.editor.setting', 'uses' => 'EditorController@setting']);
    Route::get('setting/{instanceId}/detail', ['as' => 'settings.editor.setting.detail', 'uses' => 'EditorController@getDetailSetting']);
    Route::post('setting/{instanceId}/detail', ['as' => 'settings.editor.setting.detail', 'uses' => 'EditorController@postDetailSetting']);
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
