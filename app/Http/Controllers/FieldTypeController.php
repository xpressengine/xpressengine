<?php
/**
 * FieldTypeController.php
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

use App;
use XePresenter;
use Xpressengine\Category\CategoryHandler;
use Xpressengine\Http\Request;

/**
 * Class FieldTypeController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FieldTypeController extends Controller
{
    public function storeCategory(Request $request, CategoryHandler $categoryHandler)
    {
        $this->validate($request, ['categoryName' => 'required']);
        
        $category = $categoryHandler->createCate([
            'name' => $request->get('categoryName'),
        ]);

        return XePresenter::makeApi(
            $category->getAttributes()
        );
    }
}
