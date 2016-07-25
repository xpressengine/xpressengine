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

Route::get('/locale/{locale}', 'LangController@setLocale');

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
        Route::get('lines/{key}', ['as' => 'manage.lang.lines.key', 'uses' => 'LangController@getLinesWithKey']);
        Route::get('search/{locale}', ['as' => 'manage.lang.search', 'uses' => 'LangController@searchKeyword']);
        Route::put('save', ['as' => 'manage.lang.save', 'uses' => 'LangController@save']);
        Route::get(
            '{namespace?}/{keyword?}',
            [
                'as' => 'manage.lang.index',
                'uses' => 'LangController@index',
                'settings_menu' => ['lang.default']
            ]
        );
    }
);

/* member */

/*
 * member/auth
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
 * member/profile
 * */
Route::group(
    ['prefix' => '@{member}'],
    function () {
        // profile
        Route::get('/', ['as' => 'member.profile', 'uses' => 'Member\ProfileController@index']);
        Route::post('/', ['as' => 'member.profile.update', 'uses' => 'Member\ProfileController@update']);
    }
);

Route::group(
    ['prefix' => '@{member}'],
    function () {
        // profile
        Route::get('/', ['as' => 'member.profile', 'uses' => 'Member\ProfileController@index']);
        Route::post('/', ['as' => 'member.profile.update', 'uses' => 'Member\ProfileController@update']);
    }
);

/*
 * member settings
 * */
Route::group(
    ['prefix' => 'user'],
    function () {

        Route::get('/{section?}', ['as' => 'member.settings', 'uses' => 'Member\UserController@show']);

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
                                'as' => 'member.settings.name.update',
                                'uses' => 'Member\UserController@updateDisplayName'
                            ]
                        );

                        // check name exists
                        Route::post(
                            'check',
                            [
                                'as' => 'member.settings.name.check',
                                'uses' => 'Member\UserController@validateDisplayName'
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
                                'as' => 'member.settings.password.update',
                                'uses' => 'Member\UserController@updatePassword'
                            ]
                        );
                        // check password is valid
                        Route::post(
                            'check',
                            [
                                'as' => 'member.settings.password.check',
                                'uses' => 'Member\UserController@validatePassword'
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
                            ['as' => 'member.settings.mail.list', 'uses' => 'Member\UserController@getMailList']
                        );
                        Route::post(
                            'add',
                            ['as' => 'member.settings.mail.add', 'uses' => 'Member\UserController@addMail']
                        );
                        Route::post(
                            'update',
                            ['as' => 'member.settings.mail.update', 'uses' => 'Member\UserController@updateMainMail']
                        );
                        Route::post(
                            'confirm',
                            ['as' => 'member.settings.mail.confirm', 'uses' => 'Member\UserController@confirmMail']
                        );
                        Route::post(
                            'delete',
                            ['as' => 'member.settings.mail.delete', 'uses' => 'Member\UserController@deleteMail']
                        );
                    }
                );

                Route::group(
                    ['prefix' => 'pending_mail'],
                    function () {
                        Route::post(
                            'delete',
                            [
                                'as' => 'member.settings.pending_mail.delete',
                                'uses' => 'Member\UserController@deletePendingMail'
                            ]
                        );
                        Route::post(
                            'resend',
                            [
                                'as' => 'member.settings.pending_mail.resend',
                                'uses' => 'Member\UserController@resendPendingMail'
                            ]
                        );
                    }
                );

                Route::group(
                    ['prefix' => 'leave'],
                    function () {
                        Route::post(
                            '/',
                            [
                                'as' => 'member.settings.leave',
                                'uses' => 'Member\UserController@leave'
                            ]
                        );
                    }
                );
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
                'as' => 'settings.member.index',
                'uses' => 'Member\Settings\UserController@index',
                'settings_menu' => 'member.list',
                'permission' => 'user.list'
            ]
        );

        // create
        Route::get('create',
                   [
                       'as' => 'settings.member.create',
                       'uses' => 'Member\Settings\UserController@create',
                       'settings_menu' => 'member.create'
                   ]
        );
        Route::post(
            'store',
            ['as' => 'settings.member.store', 'uses' => 'Member\Settings\UserController@store']
        );

        Route::get(
            '{id}/edit',
            [
                'as' => 'settings.member.edit',
                'uses' => 'Member\Settings\UserController@edit',
                'settings_menu' => 'member.edit',
                'permission' => 'user.edit',

            ]
        )->where('id', '[0-9a-z\-]+');

        Route::post('{id}/edit', ['as' => 'settings.member.edit', 'uses' => 'Member\Settings\UserController@update'])
            ->where('id', '[0-9a-z\-]+');

        // mail action at edit
        Route::get(
            'mail/list',
            ['as' => 'settings.member.mail.list', 'uses' => 'Member\Settings\UserController@getMailList']
        );
        Route::post(
            'mail/add',
            ['as' => 'settings.member.mail.add', 'uses' => 'Member\Settings\UserController@postAddMail']
        );
        Route::post(
            'mail/delete',
            ['as' => 'settings.member.mail.delete', 'uses' => 'Member\Settings\UserController@postDeleteMail']
        );
        Route::post(
            'mail/confirm',
            ['as' => 'settings.member.mail.confirm', 'uses' => 'Member\Settings\UserController@postConfirmMail']
        );

        // delete
        Route::delete(
            'destroy',
            ['as' => 'settings.member.destroy', 'uses' => 'Member\Settings\UserController@deleteMember']
        );

        // setting
        Route::group(
            ['prefix' => 'setting'],
            function () {

                Route::get(
                    '/',
                    [
                        'as' => 'settings.member.setting',
                        'uses' => 'Member\Settings\SettingController@editCommon',
                        'settings_menu' => 'member.setting.default',
                        'permission' => 'user.setting'
                    ]
                );
                Route::post(
                    '/',
                    ['as' => 'settings.member.setting', 'uses' => 'Member\Settings\SettingController@updateCommon']
                );

                Route::get(
                    'join',
                    [
                        'as' => 'settings.member.setting.join',
                        'uses' => 'Member\Settings\SettingController@editJoin',
                        'settings_menu' => 'member.setting.join',
                        'permission' => 'user.setting'
                    ]
                );

                Route::post(
                    'join',
                    [
                        'as' => 'settings.member.setting.join',
                        'uses' => 'Member\Settings\SettingController@updateJoin'
                    ]
                );

                Route::get(
                    'skin',
                    [
                        'as' => 'settings.member.setting.skin',
                        'uses' => 'Member\Settings\SettingController@editSkin',
                        'settings_menu' => 'member.setting.skin',
                        'permission' => 'user.setting'
                    ]
                );

                Route::get(
                    'field',
                    [
                        'as' => 'settings.member.setting.field',
                        'uses' => 'Member\Settings\SettingController@editField',
                        'settings_menu' => 'member.setting.field',
                        'permission' => 'user.setting'
                    ]
                );

                Route::get(
                    'togglemenu',
                    [
                        'as' => 'settings.member.setting.menu',
                        'uses' => 'Member\Settings\SettingController@editToggleMenu',
                        'settings_menu' => 'member.setting.menu',
                        'permission' => 'user.setting'
                    ]
                );

            }
        );

        Route::get(
            'searchMember/{keyword?}',
            ['as' => 'settings.member.search', 'uses' => 'Member\Settings\UserController@search']
        );
    }
);

/*
 * member group
 * */
Route::settings(
    'group',
    function () {

        Route::get(
            'searchGroup/{keyword?}',
            ['as' => 'manage.group.search', 'uses' => 'Member\Settings\GroupController@search']
        );

        // list
        Route::get(
            '/',
            [
                'as' => 'manage.group.index',
                'uses' => 'Member\Settings\GroupController@index',
                'settings_menu' => ['member.group']
            ]
        );

        // create
        Route::get('create', ['as' => 'manage.group.create', 'uses' => 'Member\Settings\GroupController@create', 'settings_menu' => ['member.group.create']]);
        Route::post('create', ['as' => 'manage.group.create', 'uses' => 'Member\Settings\GroupController@store']);

        // edit
        Route::get(
            '{id}/edit',
            [
                'as' => 'manage.group.edit',
                'uses' => 'Member\Settings\GroupController@edit',
                'settings_menu' => ['member.group.edit']
            ]
        )->where('id', '[0-9a-z\-]+');
        Route::post('{id}/edit', ['as' => 'manage.group.edit', 'uses' => 'Member\Settings\GroupController@update'])
            ->where('id', '[0-9a-z\-]+');

        Route::post('update/join', ['as' => 'manage.group.update.join', 'uses' => 'Member\Settings\GroupController@updateJoinGroup'])
            ->where('id', '[0-9a-z\-]+');

        // delete
        Route::delete(
            'destroy',
            ['as' => 'manage.group.destroy', 'uses' => 'Member\Settings\GroupController@destroy']
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

        Route::post('store/theme', ['as' => 'settings.setting.theme', 'uses' => 'SettingsController@updateTheme']);

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

/* theme package */
Route::settings(
    'theme',
    function () {
        Route::get('edit', ['as' => 'settings.theme.edit', 'uses' => 'ThemeController@edit']);
        Route::post('edit', ['as' => 'settings.theme.edit', 'uses' => 'ThemeController@update']);

        Route::get('setting', ['as' => 'settings.theme.setting', 'uses' => 'ThemeController@editSetting']);
        Route::post('setting', ['as' => 'settings.theme.setting', 'uses' => 'ThemeController@updateSetting']);

        Route::post('setting/create', ['as' => 'settings.theme.setting.create', 'uses' => 'ThemeController@createSetting']);
    }
);

/* plugin package */
Route::settings(
    'plugins',
    function () {
        Route::get(
            '/',
            [
                'as' => 'settings.plugins',
                'uses' => 'PluginController@index',
                'settings_menu' => ['plugin.list']
            ]
        );

        Route::get(
            '{pluginId?}',
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
    Route::get('/storeCategory', ['as' => 'fieldType.storeCategory', 'uses' => 'FieldTypeController@storeCategory']);
});

Route::group(['prefix' => 'temporary'], function () {
    Route::get('/', ['as' => 'temporary.index', 'uses' => 'TemporaryController@index']);
    Route::post('store', ['as' => 'temporary.store', 'uses' => 'TemporaryController@store']);
    Route::post('update/{temporaryId}', ['as' => 'temporary.update', 'uses' => 'TemporaryController@update'])
        ->where('temporaryId', '[0-9a-z\-]+');
    Route::post('destroy/{temporaryId}', ['as' => 'temporary.destroy', 'uses' => 'TemporaryController@destroy'])
        ->where('temporaryId', '[0-9a-z\-]+');

    Route::post('setAuto', ['as' => 'temporary.setAuto', 'uses' => 'TemporaryController@setAuto']);
    Route::post('destroyAuto', ['as' => 'temporary.destroyAuto', 'uses' => 'TemporaryController@destroyAuto']);
});

Route::settings('widget', function () {
    Route::get('list', ['as' => 'manage.widget.list', 'uses' => 'WidgetController@index']);
    Route::get('setup', ['as' => 'manage.widget.setup', 'uses' => 'WidgetController@setup']);
    Route::get('render', ['as' => 'manage.widget.render', 'uses' => 'WidgetController@render']);
    Route::get('generate', ['as' => 'manage.widget.generate', 'uses' => 'WidgetController@generate']);

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

/* skin package */
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

Route::get('widgetbox/edit/{boxId}', ['as' => 'widgetbox.edit', 'uses' => 'WidgetBoxController@edit']);
