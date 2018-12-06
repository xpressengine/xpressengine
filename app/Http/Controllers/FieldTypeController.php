<?php
/**
 * FieldTypeController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
