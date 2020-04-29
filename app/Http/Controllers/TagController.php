<?php
/**
 * TagController.php
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
use XeTag;
use Xpressengine\Http\Request;

/**
 * Class TagController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TagController extends Controller
{
    /**
     * Search tags by given text.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function autoComplete(Request $request)
    {
        $words = XeTag::similarWord($request->get('string'));

        return XePresenter::makeApi($words);
    }
}
