<?php
/**
 * TermsController.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeDB;
use XeLang;
use XePresenter;
use Xpressengine\Http\Request;

class TermsController extends Controller
{
    public function index()
    {
        $terms = app('xe.terms')->all();

        return XePresenter::make('user.settings.setting.terms.index', compact('terms'));
    }

    public function create()
    {
        return XePresenter::make('user.settings.setting.terms.create', [
            'locales' => XeLang::getLocales()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'langRequired']);

        $last = app('xe.terms')->lastOrder();
        app('xe.terms')->create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'order' => $last ? $last + 1 : 0
        ]);

        return redirect()->route('settings.user.setting.terms.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::saved')
        ]);
    }

    public function edit($id)
    {
        $term = app('xe.terms')->find($id);

        return XePresenter::make('user.settings.setting.terms.edit', [
            'term' => $term
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!$term = app('xe.terms')->find($id)) {
            throw new HttpException(422, "undefined [#$id]");
        }

        $this->validate($request, ['title' => 'langRequired']);

        app('xe.terms')->update($term, [
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        return redirect()->route('settings.user.setting.terms.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::saved')
        ]);
    }

    public function destroies(Request $request)
    {
        XeDB::transaction(function () use ($request) {
            foreach ($request->get('id', []) as $id) {
                app('xe.terms')->delete(app('xe.terms')->find($id));
            }
        });

        return redirect()->route('settings.user.setting.terms.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::msgDelete')
        ]);
    }

    public function enable(Request $request)
    {
        XeDB::transaction(function () use ($request) {
            $enables = $request->get('enable');
            $terms = app('xe.terms')->all();
            $terms = $terms->partition(function ($term) use ($enables) {
                return in_array($term->id, $enables);
            });

            $enables = array_merge(array_flip($enables), $terms->first()->keyBy('id')->all());
            app('xe.terms')->enable(array_values($enables));
            app('xe.terms')->disable($terms->last());
        });

        return redirect()->route('settings.user.setting.terms.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::saved')
        ]);
    }
}
