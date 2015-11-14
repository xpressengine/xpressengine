<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use PhpQuery\PhpQueryObject;
use Xpressengine\Support\Exceptions\HttpXpressengineException;

class DashboardController extends Controller
{

    public function index()
    {
        \Frontend::title('XpressEngine3 Settings');

        return \Presenter::make('settings.dashboard');
    }
}
