<?php
/**
 * SettingController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use App\Http\Sections\DynamicFieldSection;
use App\Http\Sections\SkinSection;
use App\Http\Sections\ToggleMenuSection;
use XePresenter;
use Xpressengine\Captcha\CaptchaManager;
use Xpressengine\Captcha\Exceptions\ConfigurationNotExistsException;
use Xpressengine\Http\Request;
use Xpressengine\User\UserHandler;

/**
 * Class SettingController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SettingController extends Controller
{

    protected $users;

    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->users = app('xe.users');
    }

    /**
     * edit user setting
     *
     * @param CaptchaManager $captcha CaptchaManager instance
     * @param UserHandler    $handler UserHandler instance
     *
     * @return mixed|\Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.8 instead use RegisterSettingsController@editSetting
     */
    public function editSetting(CaptchaManager $captcha, UserHandler $handler)
    {
        $config = app('xe.config')->get('user.register');

        $parts = $handler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        $parts = collect($parts)->partition(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        });
        $parts->splice(0, 1, [array_merge(array_flip($activated), $parts->first()->all())]);

        return XePresenter::make(
            'user.settings.setting.common',
            compact('config', 'captcha', 'parts')
        );
    }

    /**
     * update user setting
     *
     * @param Request        $request request
     * @param CaptchaManager $captcha CaptchaManager instance
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since 3.0.8 instead use RegisterSettingsController@updateSetting
     */
    public function updateSetting(Request $request, CaptchaManager $captcha)
    {
        $inputs = $request->except('_token');
        $config = app('xe.config')->get('user.register');

        if (isset($inputs['useCaptcha']) && $inputs['useCaptcha'] === 'true' && !$captcha->available()) {
            throw new ConfigurationNotExistsException();
        }

        $inputs['forms'] = array_keys(array_get($inputs, 'forms', []));

        if (isset($inputs['guard_forced'])) {
            $inputs['guard_forced'] = $inputs['guard_forced'] === 'true';
        }

        foreach ($inputs as $key => $val) {
            $config->set($key, $val);
        }
        app('xe.config')->modify($config);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * get Common setting
     *
     * @param CaptchaManager $captcha CaptchaManager instance
     * @return \Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.2 instead use editSetting
     */
    public function editCommon(CaptchaManager $captcha)
    {
        $config = app('xe.config')->get('user.common');

        return XePresenter::make(
            'user.settings.setting.common',
            compact('config', 'captcha')
        );
    }

    /**
     * update Common setting
     *
     * @param Request        $request request
     * @param CaptchaManager $captcha CaptchaManager instance
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since 3.0.2 instead use editSetting
     */
    public function updateCommon(Request $request, CaptchaManager $captcha)
    {
        $inputs = $request->only(['useCaptcha']);

        if ($inputs['useCaptcha'] === 'true' && !$captcha->available()) {
            throw new ConfigurationNotExistsException();
        }

        $oldConfig = app('xe.config')->get('user.common')->getPureAll();
        $inputs = array_merge($oldConfig, $inputs);

        app('xe.config')->put('user.common', $inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * edit Join setting
     *
     * @param CaptchaManager $captcha CaptchaManager instance
     * @return \Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.2 instead use editSetting
     */
    public function editJoin(CaptchaManager $captcha, UserHandler $handler)
    {
        $config = app('xe.config')->get('user.register');

        $parts = $handler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        $parts = collect($parts)->partition(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        });
        $parts->splice(0, 1, [array_merge(array_flip($activated), $parts->first()->all())]);

        return XePresenter::make(
            'user.settings.setting.join',
            compact('config', 'captcha', 'parts')
        );
    }

    /**
     * update Join setting
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since 3.0.2 instead use editSetting
     */
    public function updateJoin(Request $request)
    {
        $inputs = $request->except('_token');

        $inputs['forms'] = array_keys(array_get($inputs, 'forms', []));

        $config = app('xe.config')->get('user.register');

        $inputs['guard_forced'] = $inputs['guard_forced'] === 'true';

        foreach ($inputs as $key => $val) {
            $config->set($key, $val);
        }
        app('xe.config')->modify($config);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * edit Skin setting
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function editSkin()
    {
        $authSkinSection = new SkinSection('user/auth');

        $settingsSkinSection = new SkinSection('user/settings');

        $profileSkinSection = new SkinSection('user/profile');

        return XePresenter::make(
            'user.settings.setting.skin',
            compact('authSkinSection', 'settingsSkinSection', 'profileSkinSection')
        );
    }

    /**
     * edit ToggleMenu setting
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function editToggleMenu()
    {
        $toggleMenuSection = new ToggleMenuSection('user');

        return XePresenter::make(
            'user.settings.setting.usermenu',
            compact('toggleMenuSection')
        );
    }
}
