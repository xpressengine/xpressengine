<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use XePresenter;
use XeTheme;

class PolicyController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        XeTheme::selectSiteTheme();
        //XePresenter::setSkinTargetId('member/settings');
    }

    public function privacy()
    {
        $config = app('xe.config')->get('user.common');
        $privacy = $config->get('privacy');
        return XePresenter::make('policies.privacy', compact('privacy'));
    }

    public function service()
    {
        $config = app('xe.config')->get('user.common');
        $service = $config->get('agreement');
        return XePresenter::make('policies.terms.service', compact('service'));
    }

}
