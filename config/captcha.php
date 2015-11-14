<?php
return [
    'driver' => env('CAPTCHA_DRIVER', 'google'),

    'apis' => [
        'google' => [
            'siteKey' => env('CAPTCHA_APIS_GOOGLE_SITEKEY', null),
            'secret' => env('CAPTCHA_APIS_GOOGLE_SECRET', null)
        ],
    ]
];
