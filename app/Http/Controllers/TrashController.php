<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use XeTrash;
use Request;
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
        $ids = Request::get('ids');
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

        if (Request::get('redirect') != null) {
            return redirect(Request::get('redirect'));
        } else {
            return redirect()->route('manage.trash.index');
        }
    }
}
