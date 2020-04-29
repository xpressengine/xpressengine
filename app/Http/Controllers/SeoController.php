<?php
/**
 * SeoController.php
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

use XePresenter;
use XeStorage;
use XeMedia;
use XeFrontend;
use XeSEO;
use Xpressengine\Http\Request;

/**
 * Class SeoController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 *
 * @deprecated since 3.0.2 use SettingController instead
 */
class SeoController extends Controller
{
    /**
     * Show setting page for SEO.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getSetting()
    {
        $ruleName = 'seoSetting';

        XeFrontend::rule($ruleName, $this->getRules());

        return XePresenter::make('seo.setting', [
            'setting' => XeSEO::getSetting(),
            'ruleName' => $ruleName
        ]);
    }

    /**
     * Save setting information.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSetting(Request $request)
    {
        $this->validate($request, $this->getRules());

        $inputs = $request->only([
            'mainTitle',
            'subTitle',
            'keywords',
            'description',
            'twitterUsername',
        ]);
        $setting = XeSEO::getSetting();
        $setting->set($inputs);

        if ($request->file('siteImage') !== null) {
            $file = XeStorage::upload($request->file('siteImage'), 'public/seo');
            $image = XeMedia::make($file);
            $setting->setSiteImage($image);
        }

        return redirect()->route('manage.seo.edit');
    }

    /**
     * Returns validation rules.
     *
     * @return array
     */
    private function getRules()
    {
        return [
            'mainTitle' => 'LangRequired',
            'keywords' => 'Required',
        ];
    }
}
