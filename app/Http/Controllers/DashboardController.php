<?php
namespace App\Http\Controllers;

use App\Http\Requests;

class DashboardController extends Controller
{

    public function index()
    {
        \XeFrontend::title('XpressEngine3 Settings');

        return \Presenter::make('settings.dashboard');
    }
}
