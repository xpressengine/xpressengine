<?php
/**
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

class FieldTypeController extends Controller
{
    public function __construct()
    {

    }

    public function storeCategory(Request $request, CategoryHandler $categoryHandler)
    {
        $input = [
            'name' => $request->get('categoryName'),
        ];
        $category = $categoryHandler->create($input);

        return XePresenter::makeApi(
            $category->getAttributes()
        );
    }
}
