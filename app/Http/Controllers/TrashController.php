<?php
namespace App\Http\Controllers;

use XeTrash;
use Input;
use XePresenter;

class TrashController extends Controller
{
    public function index()
    {
        $wastes = XeTrash::gets();

        return XePresenter::make('trash.index', [
            'wastes' => $wastes,
        ]);
    }

    public function clean()
    {
        // id 는 배열로 넘어옴
        $ids = Input::get('ids');
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

        if (Input::get('redirect') != null) {
            return redirect(Input::get('redirect'));
        } else {
            return redirect()->route('manage.trash.index');
        }
    }
}