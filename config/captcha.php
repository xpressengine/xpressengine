<?php
/**
 * captcha.php
 *
 * PHP version 7
 *
 * @category    Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
