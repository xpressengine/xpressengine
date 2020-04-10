<?php
/**
 * TermsController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeDB;
use XeLang;
use XePresenter;
use Xpressengine\Http\Request;

/**
 * Class TermsController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\User\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TermsController extends Controller
{
    /**
     * Show list for registered terms.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index()
    {
        $terms = app('xe.terms')->all();

        return XePresenter::make('user.settings.setting.terms.index', compact('terms'));
    }

    /**
     * Show the term registration form.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function create()
    {
        return XePresenter::make('user.settings.setting.terms.create', [
            'locales' => XeLang::getLocales()
        ]);
    }

    /**
     * Create a term.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'langRequired']);

        $last = app('xe.terms')->lastOrder();
        app('xe.terms')->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'content' => $request->get('content'),
            'is_require' => $request->get('is_require') === 'require',
            'order' => $last ? $last + 1 : 0
        ]);

        return redirect()->route('settings.user.setting.terms.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::saved')
        ]);
    }

    /**
     * Show edit form for the term
     *
     * @param string $id identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function edit($id)
    {
        $term = app('xe.terms')->find($id);

        return XePresenter::make('user.settings.setting.terms.edit', [
            'term' => $term
        ]);
    }

    /**
     * Update a term.
     *
     * @param Request $request request
     * @param string  $id      identifier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if (!$term = app('xe.terms')->find($id)) {
            throw new HttpException(422, "undefined [#$id]");
        }

        $this->validate($request, ['title' => 'langRequired']);

        app('xe.terms')->update($term, [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'content' => $request->get('content'),
            'is_require' => $request->get('is_require') === 'require'
        ]);

        return redirect()->route('settings.user.setting.terms.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::saved')
        ]);
    }

    /**
     * Destroy terms.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroies(Request $request)
    {
        XeDB::transaction(function () use ($request) {
            foreach ($request->get('id', []) as $id) {
                app('xe.terms')->delete(app('xe.terms')->find($id));
            }
        });

        return redirect()->route('settings.user.setting.terms.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::deleted')
        ]);
    }

    /**
     * Set enables terms.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Request $request)
    {
        XeDB::transaction(function () use ($request) {
            $enables = $request->get('enable') ?: [];
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
