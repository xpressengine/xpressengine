<?php
/**
 * CaptchaController.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Xpressengine\Captcha\Services\NaverCaptcha;
use XePresenter;

class CaptchaController extends Controller
{
    public function naverReissue()
    {
        if (config('captcha.driver') !== 'naver') {
            abort(403);
        }

        /** @var NaverCaptcha $service */
        $service = app('xe.captcha')->driver('naver');
        $key = $service->issue();

        return XePresenter::makeApi([
            'key' => $key,
            'img' => $service->getImgSrc($key),
        ]);
    }
}
