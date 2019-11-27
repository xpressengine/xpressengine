<?php
/**
 * RegisterSettingsController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
namespace App\Http\Controllers;

use Xpressengine\Http\Request;
use Xpressengine\User\UserHandler;

/**
 * Class SettingController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class RegisterSettingsController extends Controller
{
    public function editSetting(Request $request, UserHandler $userHandler)
    {
        $config = app('xe.config')->get('user.register');

        $parts = $userHandler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        $parts = collect($parts)->partition(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        });
        $parts->splice(0, 1, [array_merge(array_flip($activated), $parts->first()->all())]);

        return \XePresenter::make('settings.register', compact('config', 'parts'));
    }

    /**
     * update register setting
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSetting(Request $request)
    {
        $inputs = $request->except('_token');
        app('xe.user_register')->updateConfig($inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }
}
