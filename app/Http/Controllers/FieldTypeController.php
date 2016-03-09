<?php
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
