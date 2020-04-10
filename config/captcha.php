<?php
/**
 * captcha.php
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
    'driver' => env('CAPTCHA_DRIVER', 'google'),

    'apis' => [
        'google' => [
            'siteKey' => env('CAPTCHA_APIS_GOOGLE_SITEKEY', null),
            'secret' => env('CAPTCHA_APIS_GOOGLE_SECRET', null)
        ],
        'naver' => [
            'clientId' => env('CAPTCHA_APIS_NAVER_CLIENT_ID', null),
            'secret' => env('CAPTCHA_APIS_NAVER_SECRET', null)
        ],
    ]
];
