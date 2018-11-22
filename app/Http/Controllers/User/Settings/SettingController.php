<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use App\Http\Sections\DynamicFieldSection;
use App\Http\Sections\SkinSection;
use App\Http\Sections\ToggleMenuSection;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XePresenter;
use Xpressengine\Captcha\CaptchaManager;
use Xpressengine\Captcha\Exceptions\ConfigurationNotExistsException;
use Xpressengine\Http\Request;
use Xpressengine\User\UserHandler;

/**
 * @category
 * @package     App\Http\Controllers\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
     * get Common setting
     *
     * @param CaptchaManager $captcha
     *
     * @return \Xpressengine\Presenter\Presentable
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
     * @param Request        $request
     * @param CaptchaManager $captcha
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCommon(Request $request, CaptchaManager $captcha)
    {
        $inputs = $request->only(['useCaptcha', 'webmasterName', 'webmasterEmail']);

        if ($inputs['useCaptcha'] === 'true' && !$captcha->available()) {
            throw new ConfigurationNotExistsException();
        }

        app('xe.config')->put('user.common', $inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * edit Join setting
     *
     * @param CaptchaManager $captcha
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function editJoin(CaptchaManager $captcha, UserHandler $handler)
    {
        $config = app('xe.config')->get('user.join');

        $parts = $handler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        $parts = collect($parts)->partition(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        });
        $parts->splice(0, 1, [array_merge(array_flip($activated), $parts->first()->all())]);

        return XePresenter::make(
            'user.settings.setting.join',
            compact('config','captcha', 'parts')
        );
    }


    /**
     * update Join setting
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateJoin(Request $request)
    {
        $inputs = $request->except('_token');

        $inputs['forms'] = array_keys(array_get($inputs, 'forms', []));

        $config = app('xe.config')->get('user.join');

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
     * edit Field setting
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function editField()
    {
        $connection = $this->users->getConnection();
        $dynamicFieldSection = new DynamicFieldSection('user', $connection, false);

        return XePresenter::make(
            'user.settings.setting.field',
            compact('dynamicFieldSection')
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
