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
use Xpressengine\User\Models\Term;
use Xpressengine\User\TermsHandler;

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
     * @var TermsHandler
     */
    protected $handler;

    /**
     * TermsController constructor.
     *
     * @param TermsHandler $handler
     */
    public function __construct(TermsHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Show list for registered terms.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index()
    {
        $terms = $this->handler->all();

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

        $last = $this->handler->lastOrder();
        $this->handler->create([
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
        $term = $this->handler->find($id);

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
        if (!$term = $this->handler->find($id)) {
            throw new HttpException(422, "undefined [#$id]");
        }

        $this->validate($request, ['title' => 'langRequired']);

        $this->handler->update($term, [
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
                $this->handler->delete($this->handler->find($id));
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
            $orders = array_flip(array_wrap($request->get('orders')));
            $enables = $request->get('enable') ?: [];

            /** @var \Illuminate\Database\Eloquent\Collection $terms */
            $terms = $this->handler->all()->sortBy(function (Term $term, int $key) use ($orders) {
                return array_get($orders, $term->id) ?? $key;
            });

            list($enableTerms, $disableTerms) = $terms->partition(function ($term) use ($enables) {
                return in_array($term->id, $enables);
            });

            $this->handler->enable($enableTerms->values());
            $this->handler->disable($disableTerms->values());
        });

        return redirect()->route('settings.user.setting.terms.index')->with('alert', [
            'type' => 'success', 'message' => xe_trans('xe::saved')
        ]);
    }
}
