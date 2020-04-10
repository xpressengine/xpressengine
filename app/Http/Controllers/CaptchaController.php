<?php
/**
 * CaptchaController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Xpressengine\Captcha\Services\NaverCaptcha;
use XePresenter;

/**
 * Class CaptchaController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CaptchaController extends Controller
{
    /**
     * Reissue captcha of naver provider.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
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
