<?php
/**
 * xe.php
 *
 * PHP version 7
 *
 * @category    Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

return [
    'routing' => [
        'settingsPrefix' => 'settings',
        'safeModePrefix' => '__safe_mode',
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

        'locale_type' => null, // null(cookie), route, domain
        'locale_domains' => [
            'ko' => 'example1.test',
            'en' => 'example2.test',
        ]
    ],

    'ssl' => [
        'always' => false,
    ],

    'console_allow_url_fopen' => true,

    'composer_no_cache' => false,

    'settings' => [
        /*
        |--------------------------------------------------------------------------
        | Settings page accessable client CIDR
        |--------------------------------------------------------------------------
        | 설정페이지에 접근할 수 있는 클라이언트 주소를 지정합니다.
        | 기본으로 설정된 0.0.0.0/0 은 모든 클라이언트를 의미합니다. 앞에 0.0.0.0 는 네트워크 주소를
        | 나타내고, '/' 뒤 숫자는 네트워크 그룹의 범위를 비트로 표시한것입니다. 주소는 8비트씩 '.' 을 구분자
        | 로 하여 나타냅니다. 만약 여러분이 '200.100.' 으로 시작하는 주소를 가진 클라이언트 모두 설정
        | 페이지에 접근할 수 있도록 설정하고자 하는 경우 '200.100.0.0/16' 으로 작성하시면 됩니다.
        | '200.100.50.' 으로 시작하는 모든 클라이언트를 허용하고자 할때는 '200.100.50.0/24' 로
        | 작성하면 됩니다. 범위가 아닌 특정 주소를 지정할때는 '200.100.50.1' 처럼 작성할 수 있습니다.
        | 주의할 점은, 이곳에 작성된 항목중 어느하나라도 클라이언트 주소가 포함되는 경우라면 설정페이지에 접근
        | 가능하므로 원하는 주소를 지정하는 경우 기본으로 작성된 '0.0.0.0/0' 항목을 제거하셔야 합니다.
        */
        'trusts' => [
            '0.0.0.0/0',
        ],
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
            'dashboard.home' => [
                'title' => 'xe::home',
                'display' => true,
                'description' => '',
                'ordering' => 100
            ],
            'dashboard.updates' => [
                'title' => 'xe::updates',
                'display' => true,
                'description' => '',
                'ordering' => 200
            ],
            'dashboard.operation' => [
                'title' => 'xe::operation',
                'display' => false,
                'description' => '',
                'ordering' => 200
            ],
            'sitemap' => [
                'title' => 'xe::siteMap',
                'display' => true,
                'description' => 'xe::siteMapDescription',
                'ordering' => 2000
            ],
            'sitemap.default' => [
                'title' => 'xe::editSiteMenu',
                'display' => true,
                'description' => '',
                'ordering' => 100
            ],
            'user' => [
                'title' => 'xe::user',
                'description' => '',
                'display' => true,
                'ordering' => 3000
            ],
            'user.list' => [
                'title' => 'xe::userList',
                'description' => '',
                'display' => true,
                'ordering' => 100
            ],
            'user.create' => [
                'title' => 'xe::addUser',
                'description' => '신규회원을 추가합니다.',
                'display' => false,
                'ordering' => 200
            ],
            'user.edit' => [
                'title' => 'xe::editUser',
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
            'user.menu' => [
                'title' => 'xe::toggleMenuSettings',
                'description' => '',
                'display' => true,
                'ordering' => 400
            ],
            'contents' => [
                'title' => 'xe::contents',
                'display' => true,
                'description' => '',
                'ordering' => 4000
            ],
            'contents.media_library' => [
                'title' => 'xe::media',
                'display' => true,
                'description' => '',
                'ordering' => 500
            ],
            'theme' => [
                'title' => 'xe::themeDesign',
                'display' => true,
                'description' => '',
                'ordering' => 5000
            ],
            'theme.installed' => [
                'title' => 'xe::installedTheme',
                'display' => true,
                'description' => '',
                'ordering' => 100
            ],
            'theme.install' => [
                'title' => 'xe::addTheme',
                'display' => true,
                'description' => '',
                'ordering' => 200
            ],
            'theme.globalSkin' => [
                'title' => 'xe::globalMenuSkin',
                'description' => '',
                'display' => true,
                'ordering' => 300
            ],
            'theme.setting' => [
                'title' => 'xe::settingTheme',
                'display' => true,
                'description' => '',
                'ordering' => 400
            ],
            'theme.editor' => [
                'title' => 'xe::themeEditor',
                'display' => true,
                'description' => '',
                'ordering' => 500
            ],
            'extension' => [
                'title' => 'xe::extension',
                'display' => true,
                'description' => '',
                'ordering' => 5000
            ],
            'extension.installed' => [
                'title' => 'xe::installedExtension',
                'display' => true,
                'description' => '',
                'ordering' => 100
            ],
            'extension.install' => [
                'title' => 'xe::addExtension',
                'display' => true,
                'description' => '',
                'ordering' => 200
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
            'setting.register' => [
                'title' => 'xe::registerSettings',
                'display' => true,
                'description' => '회원가입에 관한 허용 및 절차, 회원가입 폼 관리를 할 수 있습니다.',
                'ordering' => 200
            ],
            'setting.terms' => [
                'title' => 'xe::termAndInstructions',
                'description' => '',
                'display' => true,
                'ordering' => 300
            ],
            'setting.permission' => [
                'title' => 'xe::settingsPermissionSettings',
                'display' => true,
                'description' => '',
                'ordering' => 400
            ],
            'setting.admin-log' => [
                'title' => 'xe::adminLog',
                'display' => true,
                'description' => '관리자 권한을 가진 회원이 실행한 작업을 볼 수 있습니다.',
                'ordering' => 500
            ],
            'setting.editor' => [
                'title' => 'xe::editorSetting',
                'display' => true,
                'description' => '',
                'ordering' => 600
            ],
            'setting.media_library' => [
                'title' => 'xe::media',
                'display' => true,
                'description' => '',
                'ordering' => 700
            ],
            'setting.lang' => [
                'title' => 'xe::multiLangSettings',
                'display' => true,
                'description' => '다국어를 설정합니다',
                'ordering' => 800
            ],
        ]
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

        //deprecated since 3.0.8
        //관리자 페이지->설정->가입 설정->비밀번호 정책 수정 기능으로 대체
        'password' => [
            'default' => 'normal',
            'levels' => [
                'weak' => 'min:4',
                'normal' => 'min:6|alpha|numeric',
                'strong' => 'min:8|alpha|numeric|special_char',
            ]
        ],


        'profileImage' => [
            'default' => 'assets/core/user/img/default_avatar.jpg',
            'size' => ['width' => 240, 'height' => 240],
            'storage' => [
                'disk' => 'local',
                'path' => 'public/user/profile_image'
            ]
        ],
        'registrationAutoLogin' => true,
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
            //'getByUser' => function ($user) {
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
            'url' => 'https://store.xehub.io/api/1.3'
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
            'formRadio' => 'uiobject/xpressengine@formRadio',
            'formFile' => 'uiobject/xpressengine@formFile',
            'formImage' => 'uiobject/xpressengine@formImage',
            'formMedialibraryImage' => 'uiobject/xpressengine@formMedialibraryImage',
            'formColorpicker' => 'uiobject/xpressengine@formColorpicker',
            'formMenu' => 'uiobject/xpressengine@menuSelect',
            'formLangText' => 'uiobject/xpressengine@formLangText',
            'formLangTextarea' => 'uiobject/xpressengine@formLangTextArea',
            'langText' => 'uiobject/xpressengine@langText',
            'langTextArea' => 'uiobject/xpressengine@langTextArea',
            'menuType' => 'uiobject/xpressengine@menuType',
            'permission' => 'uiobject/xpressengine@permission',
            'themeSelect' => 'uiobject/xpressengine@themeSelect',
            'skinSelect' => 'uiobject/xpressengine@skinSelect',
            'captcha' => 'uiobject/xpressengine@captcha',
            'widget' => 'uiobject/xpressengine@widgetGenerator',
            'widgetbox' => 'uiobject/xpressengine@widgetbox',
        ]
    ],

    'skin' => [
        'defaultSkins' => [
            'user/auth' => 'user/auth/skin/xpressengine@default',
            'user/profile' => 'user/profile/skin/xpressengine@default',
            'user/settings' => 'user/settings/skin/xpressengine@default',
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
        'alert' => 'common.alert',
    ]
];
