<?php
namespace App\Http\Controllers;

use App;
use Input;
use Presenter;
use Validator;
use Hash;
use Auth;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Permission\Action;
use Xpressengine\Support\Exceptions\HttpXpressengineException;
use Document;
use App\Sections\DynamicFieldSection;
use XeDB;
use DynamicField;
use Cfg;
use Category;
use Xpressengine\Keygen\Keygen;

class FieldTypeController extends Controller
{
    public function __construct()
    {

    }

    public function storeCategory()
    {
        $input = [
            'name' => Input::get('categoryName'),
        ];
        $category = Category::create($input);

        return Presenter::makeApi(
            $category->getAttributes()
        );
    }
}
