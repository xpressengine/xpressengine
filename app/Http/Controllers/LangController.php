<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use XePresenter;
use XeLang;
use XeDB;
use XeFrontend;
use Illuminate\Contracts\Cookie\QueueingFactory as JarContract;

class LangController extends Controller
{
    /**
     * 다국어 manage 페이지
     */
    public function index(Request $request)
    {
        $namespace = $request->get('namespace');
        $keyword = $request->get('keyword');
        
        XeFrontend::translation([
            'xe::saved', 'xe::failed'
        ]);

        $conditions = [];
        if ( $namespace ) {
            $conditions['namespace'] = $namespace;
        }
        if ( $keyword ) {
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
     * 다국어 에디터에서 다국어 추천 리스트를 얻을 때 실행
     */
    public function searchKeyword(Request $request, $locale)
    {
        $term = $request->input('term');
        $searchList = $this->search(['locale' => $locale, 'value' => $term])->get()->toArray();
        $this->withLines($searchList);
        return XePresenter::makeApi($searchList);
    }

    /**
     * 다국어 에디터가 ajax로 값을 읽은 경우 실행
     */
    public function getLinesWithKey($key)
    {
        list($namespace, $item) = XeLang::parseKey($key);
        $lines = $this->search(['namespace' => $namespace, 'item' => $item])->get()->toArray();
        return XePresenter::makeApi($lines);
    }

    /**
     * 다국어 에디터가 ajax로 값을 읽은 경우 하나의 요청으로 여러개 키 처리
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
     *
     * 미들웨어 수준에서 미리 저장되기 때문에 별다른 작업 없음
     */
    public function save()
    {
        return XePresenter::makeApi([]);
    }

    private function search($conditions = [])
    {
        $query = XeDB::table('translation');
        $query->orderBy('namespace', 'asc');
        $query->orderBy('item', 'asc');
        $query->orderBy('id', 'desc');

        if ( isset($conditions['namespace']) ) {
            $query->where('namespace', $conditions['namespace']);
        }
        if ( isset($conditions['item']) ) {
            $query->where('item', $conditions['item']);
        }
        if ( isset($conditions['locale']) ) {
            $query->where('locale', $conditions['locale']);
        }
        if ( isset($conditions['value']) ) {
            $query->where('value', 'LIKE', '%'.$conditions['value'].'%');
        }

        return $query;
    }

    private function withLines(&$searchList)
    {
        foreach ( $searchList as &$search ) {
            $namespace = $search->namespace;
            $item = $search->item;
            $search->lines = $this->search(['namespace' => $namespace, 'item' => $item])->get()->toArray();
        }
    }
}
