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

class TermsController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        XeTheme::selectSiteTheme();
    }

    public function index($id)
    {
        if (!$term = app('xe.terms')->find($id)) {
            abort(404);
        }

        return XePresenter::make('terms.index', compact('term'));
    }
}
