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

use Illuminate\Support\Collection;
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
    /**
     * @param Request     $request     request
     * @param UserHandler $userHandler user handler
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function editSetting(Request $request, UserHandler $userHandler)
    {
        $config = app('xe.config')->get('user.register');

        $parts = $userHandler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        list($activateParts, $deactivateParts) = collect($parts)->partition(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        });

        $parts = $activateParts->union($deactivateParts);

        $passwordRules = explode('|', $config->get('password_rules'));
        $passwordMinLength = array_filter($passwordRules, function ($rule) {
            return strpos($rule, 'min:') !== false;
        });

        if (count($passwordMinLength) > 0) {
            list($rule, $passwordMinLength) = explode(':', $passwordMinLength[0], 2);
        } else {
            $passwordMinLength = 6;
        }

        $dynamicFieldSortKeys = $config->get('dynamic_fields');
        $dynamicFields = Collection::make(app('xe.dynamicField')->gets('user'))
            ->sortBy(function ($field) use ($dynamicFieldSortKeys) {
                return array_search($field->getConfig()->get('id'), $dynamicFieldSortKeys);
            });

        return \XePresenter::make(
            'settings.register',
            compact('config', 'parts', 'activated', 'passwordRules', 'passwordMinLength', 'dynamicFields')
        );
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
        $this->validate($request, ['password_rules.min' => 'required|numeric|min:4']);

        $inputs = $request->except('_token');
        app('xe.user_register')->updateConfig($inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }
}
