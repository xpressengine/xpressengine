<?php
/**
 * LangController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use XePlugin;
use XePresenter;
use XeLang;
use XeDB;
use XeFrontend;

/**
 * Class LangController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LangController extends Controller
{
    /**
     * Show list of languages.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index(Request $request)
    {
        $namespace = $request->get('namespace');
        $keyword = $request->get('keyword');
        
        XeFrontend::translation([
            'xe::saved', 'xe::failed'
        ]);

        $conditions = [];
        if ($namespace) {
            $conditions['namespace'] = $namespace;
        }
        if ($keyword) {
            $conditions['value'] = $keyword;
        }

        $pagination = $this->search($conditions)->groupBy('item')->groupBy('namespace')->paginate(10);
        $searchList = $pagination->toArray()['data'];
        $this->withLines($searchList);

        $namespaces = $this->search()->groupBy('namespace')->get()->toArray();
        $namespaces = array_pluck($namespaces, 'namespace');

        return XePresenter::make('lang.index', [
            'selected_namespace' => $namespace,
            'selected_keyword' => $keyword,
            'namespaces' => $namespaces,
            'searchList' => $searchList,
            'pagination' => $pagination->appends($request->except([$pagination->getPageName()]))
        ]);
    }

    /**
     * Search languages by given keyword.
     *
     * @param Request $request request
     * @param string  $locale  locale
     * @return \Xpressengine\Presenter\Presentable
     */
    public function searchKeyword(Request $request, $locale)
    {
        $term = $request->input('term');
        $searchList = $this->search(['locale' => $locale, 'value' => $term])->get()->toArray();
        $this->withLines($searchList);

        return XePresenter::makeApi($searchList);
    }

    /**
     * Get language by given key.
     *
     * @param string $key key
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getLinesWithKey($key)
    {
        list($namespace, $item) = XeLang::parseKey($key);
        $lines = $this->search(['namespace' => $namespace, 'item' => $item])->get()->toArray();
        return XePresenter::makeApi($lines);
    }

    /**
     * Get languages by given keys.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getLinesMany(Request $request)
    {
        $keys = $request->get('keys');
        if (is_array($keys) === false) {
            $keys = [$request->get('keys')];
        }

        $fetch = [];
        foreach ($keys as $key) {
            list($namespace, $item) = XeLang::parseKey($key);
            $fetch[$key] = $this->search(['namespace' => $namespace, 'item' => $item])->get()->toArray();
        }

        return XePresenter::makeApi($fetch);
    }

    /**
     * 다국어 편집 에디터에서 저장시 실행
     * 미들웨어 수준에서 미리 저장되기 때문에 별다른 작업 없음
     *
     * @return \Xpressengine\Presenter\Presentable
     * @todo 삭제?
     */
    public function save()
    {
        return XePresenter::makeApi([]);
    }

    /**
     * Make query by given conditions.
     *
     * @param array $conditions conditions
     * @return \Xpressengine\Database\DynamicQuery
     */
    private function search($conditions = [])
    {
        $query = XeDB::table('translation');
        $query->orderBy('namespace', 'asc');
        $query->orderBy('item', 'asc');
        $query->orderBy('id', 'desc');

        if (isset($conditions['namespace'])) {
            $query->where('namespace', $conditions['namespace']);
        }
        if (isset($conditions['item'])) {
            $query->where('item', $conditions['item']);
        }
        if (isset($conditions['locale'])) {
            $query->where('locale', $conditions['locale']);
        }
        if (isset($conditions['value'])) {
            $query->where('value', 'LIKE', '%'.$conditions['value'].'%');
        }

        return $query;
    }

    /**
     * Search line for searched list.
     *
     * @param array $searchList search list
     * @return void
     */
    private function withLines(&$searchList)
    {
        foreach ($searchList as &$search) {
            $namespace = $search->namespace;
            $item = $search->item;
            $search->lines = $this->search(['namespace' => $namespace, 'item' => $item])->get()->toArray();
        }
    }

    /**
     * Show plugins for imports target.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getImport()
    {
        return api_render('lang.import', ['plugins' => XePlugin::getAllPlugins()]);
    }

    /**
     * Import languages.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function import(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            throw new AuthorizationException(xe_trans('xe::accessDenied'));
        }

        $this->validate($request, ['name' => 'required']);

        $parameters = [
            'name' => $request->get('name'),
            '--no-interaction' => true,
        ];
        if ($request->get('force')) {
            $parameters['--force'] = true;
        }
        if ($path = $request->get('path')) {
            $parameters['--path'] = $path;
        }

        Artisan::call('translation:import', $parameters);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::processed')]);
    }
}
