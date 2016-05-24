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
            'ko' => '대한민국',
            'en' => 'U.S.',
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
            'member' => [
                'title' => 'xe::member',
                'description' => '',
                'display' => true,
                'ordering' => 3000
            ],
            'member.list' => [
                'title' => 'xe::memberList',
                'description' => '',
                'display' => true,
                'ordering' => 100
            ],
            'member.create' => [
                'title' => 'xe::addMember',
                'description' => '신규회원을 추가합니다.',
                'display' => false,
                'ordering' => 200
            ],
            'member.edit' => [
                'title' => 'xe::editMember',
                'description' => '회원정보를 수정합니다',
                'display' => false,
                'ordering' => 200
            ],
            'member.group' => [
                'title' => 'xe::group',
                'description' => '',
                'ordering' => 200
            ],
            'member.group.create' => [
                'title' => '새그룹 추가',
                'description' => '',
                'display' => false,
                'ordering' => 100
            ],
            'member.group.edit' => [
                'title' => '그룹 수정',
                'description' => '',
                'display' => false,
                'ordering' => 200
            ],
            'member.setting' => [
                'title' => 'xe::settings',
                'description' => '',
                'display' => true,
                'ordering' => 400
            ],
            'member.setting.default' => [
                'title' => 'xe::defaultSettings',
                'description' => '',
                'display' => true,
                'ordering' => 100
            ],
            'member.setting.join' => [
                'title' => 'xe::joinSettings',
                'description' => '',
                'display' => true,
                'ordering' => 200
            ],
            'member.setting.skin' => [
                'title' => 'xe::skinSettings',
                'description' => '',
                'display' => true,
                'ordering' => 300
            ],
            'member.setting.field' => [
                'title' => 'xe::dynamicFieldSettings',
                'description' => '',
                'display' => true,
                'ordering' => 400
            ],
            'member.setting.menu' => [
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
            'setting.permission' => [
                'title' => 'xe::settingsPermissionSettings',
                'display' => true,
                'description' => '',
                'ordering' => 200
            ],
            'setting.seo' => [
                'title' => 'xe::SEOSettings',
                'display' => true,
                'description' => 'SEO를 설정 합니다',
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
                'description' => '다국어를 설정 합니다',
                'ordering' => 100
            ],
        ]

    ],
    'database' => [
        'default' => [
            'master' => ['default'],
            'slave' => ['default'],
        ],
        'document' => [
            'master' => ['default'],
            'slave' => ['default'],
        ],
        'comment' => [
            'master' => ['default'],
            'slave' => ['default'],
        ],
        'member' => [
            'master' => ['default'],
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
        'displayName' => [
            'validate' => function ($value) {
                if (!is_string($value) && !is_numeric($value)) {
                    return false;
                }

                if (str_contains($value, "  ")) {
                    return false;
                }

                $byte = strlen($value);
                $multiByte = mb_strlen($value);

                if ($byte === $multiByte) {
                    if ($byte < 3) {
                        return false;
                    }
                } else {
                    if ($multiByte < 2) {
                        return false;
                    }
                }

                return preg_match('/^[\pL\pM\pN][. \pL\pM\pN_-]*[\pL\pM\pN]$/u', $value);
            },
        ],
        'password' => [
            'default' => 'normal',
            'levels' => [
                'low' => [
                    'title' => '낮음',
                    'validate' => function ($password) {
                        return strlen($password) >= 4;
                    },
                    'description' => '비밀번호는 4자 이상이어야 합니다.'
                ],
                'normal' => [
                    'title' => '보통',
                    'validate' => function ($password) {
                        if (!preg_match_all(
                            '$\S*(?=\S{6,})(?=\S*[a-zA-Z])(?=\S*[\d])\S*$',
                            $password
                        )
                        ) {
                            return false;
                        }
                        return true;
                    },
                    'description' => '비밀번호는 6자리 이상이어야 하며 영문과 숫자를 반드시 포함해야 합니다.'
                ],
                'high' => [
                    'title' => '높음',
                    'validate' => function ($password) {
                        if (!preg_match_all(
                            '$\S*(?=\S{8,})(?=\S*[a-zA-Z])(?=\S*[\d])(?=\S*[\W])\S*$',
                            $password
                        )
                        ) {
                            return false;
                        }
                        return true;
                    },
                    'description' => '비밀번호는 8자리 이상이어야 하며 영문과 숫자, 특수문자를 반드시 포함해야 합니다.'
                ]
            ]
        ],
        'profileImage' => [
            'default' => 'assets/core/member/img/default_avatar.gif',
            'size' => ['width' => 240, 'height' => 240],
            'storage' => [
                'disk' => 'local',
                'path' => 'member/profile'
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

    //    'commentReplyCodeLen' => 3,

    'media' => [
        /*
         * type => fit(max resize):꽉 차게, letter(min resize): 다 들어가게, widen: 가로기준으로, heighten: 세로기준으로, stretch: 지정된 사이즈에 맞게 늘림, spill: 지정된 사이즈에 꽉차면서 넘치는 부분을 잘라내지 않음
         */
        'thumbnail' => [
            'disk' => 'local',
            'path' => 'attached',
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

    'uiobject' => [
        'aliases' => [
            'phone' => 'uiobject/xpressengine@phone',
            'formText' => 'uiobject/xpressengine@formText',
            'formPassword' => 'uiobject/xpressengine@formPassword',
            'formTextarea' => 'uiobject/xpressengine@formTextArea',
            'formSelect' => 'uiobject/xpressengine@formSelect',
            'formCheckbox' => 'uiobject/xpressengine@formCheckbox',
            'formFile' => 'uiobject/xpressengine@formFile',
            'formImage' => 'uiobject/xpressengine@formImage',
            'langText' => 'uiobject/xpressengine@langText',
            'langTextArea' => 'uiobject/xpressengine@langTextArea',
            'menu' => 'uiobject/xpressengine@menuType',
            'menuList' => 'uiobject/xpressengine@menuList',
            'menuType' => 'uiobject/xpressengine@menuType',
            'permission' => 'uiobject/xpressengine@permission',
            'visibility' => 'uiobject/xpressengine@visibility',
            'themeSelect' => 'uiobject/xpressengine@themeSelect',
            'typeList' => 'uiobject/xpressengine@typeList',
            'captcha' => 'uiobject/xpressengine@captcha',
            //            'comment' => 'uiobject/xpressengine@comment'
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
        ]
    ],

    'theme' => [
        'blank' => 'Xpressengine\Themes\BlankTheme'
    ],

    'editor' => [
        'default' => 'editor/xpressengine@textarea',
    ],

    'HtmlWrapper' => [
        'common' => 'common.base',
        'popup' => 'common.popup',
    ]
];
