<?php
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
