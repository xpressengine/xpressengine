<?php
namespace App\Http\Controllers;

use Trash;
use Input;
use Presenter;

class TrashController extends Controller
{
    public function index()
    {
        $wastes = Trash::gets();

        return Presenter::make('trash.index', [
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

        foreach (Trash::gets() as $basket) {
            if (in_array($basket, $ids)) {
                $baskets[] = $basket;
            }
        }

        Trash::clean($baskets);

        if (Input::get('redirect') != null) {
            return redirect(Input::get('redirect'));
        } else {
            return redirect()->route('manage.trash.index');
        }
    }
}