<?php
/**
 * TrashController.php
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

use XeTrash;
use Request;
use XePresenter;

/**
 * Class TrashController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TrashController extends Controller
{
    /**
     * Show the list.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index()
    {
        $wastes = XeTrash::gets();

        return XePresenter::make('trash.index', [
            'wastes' => $wastes,
        ]);
    }

    /**
     * Empty the trash
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clean()
    {
        // id 는 배열로 넘어옴
        $ids = Request::get('ids');
        if (count($ids) == 0) {
            // 에러
        }

        $baskets = [];

        foreach (XeTrash::gets() as $basket) {
            if (in_array($basket, $ids)) {
                $baskets[] = $basket;
            }
        }

        XeTrash::clean($baskets);

        if (Request::get('redirect') != null) {
            return redirect(Request::get('redirect'));
        } else {
            return redirect()->route('manage.trash.index');
        }
    }
}
