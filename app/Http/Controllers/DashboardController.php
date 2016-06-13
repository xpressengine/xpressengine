<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use App\Http\Requests;

class DashboardController extends Controller
{

    public function index()
    {
        \XeFrontend::title('XpressEngine3 Settings');

        return \XePresenter::make('settings.dashboard');
    }
}
