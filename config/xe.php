<?php

return [
    'routing' => [
        'settingsPrefix' => 'settings',
        'fixedPrefix' => 'plugin'
    ],

    'menu' => [
        'maxDepth' => 4
    ],

    'lang' => [
        'locales' => ['ko', 'en'],
        'localeTexts' => [
            'ko' => '한국어',
            'en' => 'English',
        ],
        'autocomplete' => false,
    ],

    'settings' => [
        /*
        |--------------------------------------------------------------------------
        | Settings Page Theme
        |--------------------------------------------------------------------------
        |
        */
        'theme' => 'settingsTheme/xpressengine@settings',

        /*
        |--------------------------------------------------------------------------
        | Default Settings Menus List
        |--------------------------------------------------------------------------
        |
        */
        'menus' => [
            'dashboard' => [
                'title' => 'xe::dashBoard',
                'display' => true,
                'description' => '',
                'ordering' => 1000
            ],
            'sitemap' => [
                'title' => 'xe::siteMap',
                'display' => true,
                'description' => '',
                'ordering' => 2000
            ],
            'sitemap.default' => [
                'title' => 'xe::editSiteMenu',
                'display' => true,
                'description' => '',
                'ordering' => 100
            ],
            'user' => [
                'title' => 'xe::member',
                'description' => '',
                'display' => true,
                'ordering' => 3000
            ],
            'user.list' => [
                'title' => 'xe::memberList',
                'description' => '',
                'display' => true,
                'ordering' => 100
            ],
            'user.create' => [
                'title' => 'xe::addMember',
                'description' => '신규회원을 추가합니다.',
                'display' => false,
                'ordering' => 200
            ],
            'user.edit' => [
                'title' => 'xe::editMember',
                'description' => '회원정보를 수정합니다',
                'display' => false,
                'ordering' => 200
            ],
            'user.group' => [
                'title' => 'xe::group',
                'description' => '',
                'ordering' => 200
            ],
            'user.group.create' => [
                'title' => '새그룹 추가',
                'description' => '',
                'display' => false,
                'ordering' => 100
            ],
            'user.group.edit' => [
                'title' => '그룹 수정',
                'description' => '',
                'display' => false,
                'ordering' => 200
            ],
            'user.setting' => [
                'title' => 'xe::settings',
                'description' => '',
                'display' => true,
                'ordering' => 400
            ],
            'user.setting.default' => [
                'title' => 'xe::defaultSettings',
                'description' => '',
                'display' => true,
                'ordering' => 100
            ],
            'user.setting.join' => [
                'title' => 'xe::joinSettings',
                'description' => '',
                'display' => true,
                'ordering' => 200
            ],
            'user.setting.skin' => [
                'title' => 'xe::skinSettings',
                'description' => '',
                'display' => true,
                'ordering' => 300
            ],
            'user.setting.field' => [
                'title' => 'xe::dynamicFieldSettings',
                'description' => '',
                'display' => true,
                'ordering' => 400
            ],
            'user.setting.menu' => [
                'title' => 'xe::toggleMenuSettings',
                'description' => '',
                'display' => true,
                'ordering' => 500
            ],
            'contents' => [
                'title' => 'xe::contents',
                'display' => true,
                'description' => '',
                'ordering' => 4000
            ],
            'plugin' => [
                'title' => 'xe::plugin',
                'display' => true,
                'description' => '',
                'ordering' => 5000
            ],
            'plugin.list' => [
                'title' => 'xe::pluginList',
                'display' => true,
                'description' => '',
                'ordering' => 100
            ],
            'plugin.list.detail' => [
                'title' => 'xe::pluginDetails',
                'display' => false,
                'description' => '',
                'ordering' => 100
            ],
            'setting' => [
                'title' => 'xe::settings',
                'display' => true,
                'description' => '',
                'ordering' => 6000
            ],
            'setting.default' => [
                'title' => 'xe::defaultSettings',
                'display' => true,
                'description' => '',
                'ordering' => 100
            ],
            'setting.theme' => [
                'title' => 'xe::themeSettings',
                'display' => true,
                'description' => '',
                'ordering' => 200
            ],
            'setting.theme.edit' => [
                'title' => 'xe::themeEdit',
                'display' => false,
                'description' => '',
                'ordering' => 200
            ],
            'setting.permission' => [
                'title' => 'xe::settingsPermissionSettings',
                'display' => true,
                'description' => '',
                'ordering' => 300
            ],
            'setting.seo' => [
                'title' => 'xe::SEOSettings',
                'display' => true,
                'description' => 'SEO를 설정합니다',
                'ordering' => 8000
            ],
            'lang' => [
                'title' => 'xe::multiLang',
                'display' => true,
                'description' => 'blah blah~',
                'ordering' => 7000
            ],
            'lang.default' => [
                'title' => 'xe::multiLangSettings',
                'display' => true,
                'description' => '다국어를 설정합니다',
                'ordering' => 100
            ],
        ]

    ],
    'database' => [
        'default' => [
            'slave' => ['default'],
        ],
        'document' => [
            'slave' => ['default'],
        ],
        'user' => [
            'slave' => ['default'],
        ],
    ],
    'uid' => [
        'version' => 4,
        'namespace' => 'xe',
    ],
    'user' => [
        'guest' => [
            'name' => 'Guest'
        ],
        'unknown' => [
            'name' => 'UnKnown'
        ],
        'displayName' => [
            'validate' => null
        ],
        'password' => [
            'default' => 'normal', /* weak, normal, strong */
            'levels' => []
        ],
        'profileImage' => [
            'default' => 'assets/core/member/img/default_avatar.jpg',
            'size' => ['width' => 240, 'height' => 240],
            'storage' => [
                'disk' => 'local',
                'path' => 'public/user/profile_image'
            ]
        ]
    ],

    'group' => [
        'virtualGroup' => [
            'all' => function () {
                return [];
            },
            'getByUser' => function (\Xpressengine\User\UserInterface $user) {
                return [];
            },

            // sample code
            //'all' => function () {
            //
            //    $groupInfos = [
            //        'facebook' => [
            //            'title' => '페북계정소유그룹'
            //        ],
            //        'naver' => [
            //            'title' => '네이버계정소유그룹'
            //        ],
            //        'github' => [
            //            'title' => '깃헙계정소유그룹'
            //        ],
            //    ];
            //
            //    return $groupInfos;
            //},
            //'getByUser' => function (Xpressengine\Member\Entities\MemberEntityInterface $user) {
            //
            //    $providers = [];
            //    if ($user->getAccountByProvider('facebook')) {
            //        $providers[] = 'facebook';
            //    }
            //    if ($user->getAccountByProvider('naver')) {
            //        $providers[] = 'naver';
            //    }
            //    if ($user->getAccountByProvider('github')) {
            //        $providers[] = 'github';
            //    }
            //
            //    return $providers;
            //}

        ]
    ],

    'documentReplyCodeLen' => 3,

    'media' => [
        /*
         * type => fit(max resize):꽉 차게, letter(min resize): 다 들어가게, widen: 가로기준으로, heighten: 세로기준으로, stretch: 지정된 사이즈에 맞게 늘림, spill: 지정된 사이즈에 꽉차면서 넘치는 부분을 잘라내지 않음
         */
        'thumbnail' => [
            'disk' => 'local',
            'path' => 'public/thumbnails',
            'type' => 'fit',
            'dimensions' => [
                'S' => ['width' => 200, 'height' => 200,],
                'M' => ['width' => 400, 'height' => 400,],
                'L' => ['width' => 800, 'height' => 800,],
            ],
        ],

        // use 'dummy', 'ffmpeg'
        'videoExtensionDefault' => 'dummy',
        'videoExtensions' => [
            'ffmpeg' => [
                'ffmpeg.binaries' => '/usr/local/bin/ffmpeg',
                'ffprobe.binaries' => '/usr/local/bin/ffprobe',
                'timeout' => 3600, // The timeout for the underlying process
                'ffmpeg.threads' => 4,   // The number of threads that FFMpeg should use
            ]
        ],
        'videoSnapshotFromSec' => 10
    ],

    'security' => [
        'safeMode' => true
    ],

    'plugin' => [
        'api' => [
            'url' => 'https://store.xpressengine.io/api/1.2'
        ],
        'packagist' => [
            'url' => 'https://store.xpressengine.io',
            'site_token' => null
        ],
        'operation' => [
            'time_limit' => 1200
        ]
    ],

    'uiobject' => [
        'aliases' => [
            'form' => 'uiobject/xpressengine@form',
            'formText' => 'uiobject/xpressengine@formText',
            'formPassword' => 'uiobject/xpressengine@formPassword',
            'formTextarea' => 'uiobject/xpressengine@formTextArea',
            'formSelect' => 'uiobject/xpressengine@formSelect',
            'formCheckbox' => 'uiobject/xpressengine@formCheckbox',
            'formFile' => 'uiobject/xpressengine@formFile',
            'formImage' => 'uiobject/xpressengine@formImage',
            'formMenu' => 'uiobject/xpressengine@menuSelect',
            'formLangText' => 'uiobject/xpressengine@formLangText',
            'formLangTextarea' => 'uiobject/xpressengine@formLangTextArea',
            'langText' => 'uiobject/xpressengine@langText',
            'langTextArea' => 'uiobject/xpressengine@langTextArea',
            'menuType' => 'uiobject/xpressengine@menuType',
            'permission' => 'uiobject/xpressengine@permission',
            'themeSelect' => 'uiobject/xpressengine@themeSelect',
            'captcha' => 'uiobject/xpressengine@captcha',
            'widget' => 'uiobject/xpressengine@widgetGenerator',
            'widgetbox' => 'uiobject/xpressengine@widgetbox',
        ]
    ],

    'skin' => [
        'defaultSkins' => [
            'member/auth' => 'member/auth/skin/xpressengine@default',
            'member/profile' => 'member/profile/skin/xpressengine@default',
            'member/settings' => 'member/settings/skin/xpressengine@default',
            'error' => 'error/skin/xpressengine@default',
        ],
        'defaultSettingsSkins' => [
        ],
        'storage' => [
            'disk' => 'local',
            'path' => 'public/skin/'
        ]
    ],

    'theme' => [
        'blank' => 'App\Themes\BlankTheme',
        'storage' => [
            'disk' => 'local',
            'path' => 'public/theme/'
        ]
    ],

    'editor' => [
        'default' => 'editor/xpressengine@textarea',
    ],

    'HtmlWrapper' => [
        'common' => 'common.base',
        'popup' => 'common.popup',
    ]
];
