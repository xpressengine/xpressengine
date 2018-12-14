<?php
/**
 * TermsController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use XePresenter;
use XeTheme;

/**
 * Class TermsController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TermsController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        XeTheme::selectSiteTheme();
    }

    /**
     * Show terms.
     *
     * @param string $id identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index($id)
    {
        if (!$term = app('xe.terms')->find($id)) {
            abort(404);
        }

        return XePresenter::make('terms.index', compact('term'));
    }
}
