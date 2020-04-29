<?php
/**
 * DraftController.php
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

use Auth;
use XeDraft;
use XePresenter;
use Xpressengine\Http\Request;

/**
 * Class DraftController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DraftController extends Controller
{
    /**
     * Show registered the draft data.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function index(Request $request)
    {
        if (Auth::guest() !== true) {
            $drafts = XeDraft::get($request->get('key'));

            if (!empty($drafts)) {
                uasort($drafts, function ($a, $b) {
                    if ($a->created_at == $b->created_at) {
                        return 0;
                    }
                    return ($a->created_at < $b->created_at) ? 1 : -1;
                });
            }

            return XePresenter::makeApi($drafts);
        }
    }

    /**
     * Store a draft data.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     * @throws \Exception
     */
    public function store(Request $request)
    {
        if (Auth::guest() !== true) {
            try {
                $etc = $request->except(['_token', 'key', 'rep']);
                $draft = XeDraft::set($request->get('key'), $request->get($request->get('rep')), $etc);
            } catch (\Exception $e) {
                echo $e->getMessage() . '|' . $e->getFile() . '|' . $e->getLine();

                throw $e;
            }

            return XePresenter::makeApi(['draftId' => $draft->id]);
        }

        return XePresenter::makeApi(['draftId' => null]);
    }

    /**
     * Update a draft data.
     *
     * @param Request $request request
     * @param string  $draftId identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function update(Request $request, $draftId)
    {
        if (Auth::guest() !== true) {
            if (($old = XeDraft::getById($draftId)) && $old->user_id == Auth::user()->getId()) {
                $etc = $request->except(['_token', 'rep']);
                $draft = XeDraft::put($draftId, $request->get($request->get('rep')), $etc);

                return XePresenter::makeApi(['draftId' => $draft->id]);
            }
        }

        return XePresenter::makeApi(['draftId' => null]);
    }

    /**
     * Delete a draft data.
     *
     * @param string $draftId identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function destroy($draftId)
    {
        if (Auth::guest() !== true) {
            if ($draft = XeDraft::getById($draftId)) {
                if (Auth::user()->getId() == $draft->user_id) {
                    XeDraft::remove($draft);
                }
            }
        }

        return XePresenter::makeApi(['result' => true]);
    }

    /**
     * Store a draft data by automatic request.
     *
     * @param Request $request request
     * @return null
     */
    public function setAuto(Request $request)
    {
        if (Auth::guest() === true) {
            return null;
        }

        $etc = $request->except(['_token', 'key', 'rep']);

        if ($draft = XeDraft::getAuto($request->get('key'))) {
            XeDraft::put($draft->id, $request->get($request->get('rep')), $etc);
        } else {
            XeDraft::set($request->get('key'), $request->get($request->get('rep')), $etc, true);
        }
    }

    /**
     * Delete a draft data of automatic registered.
     *
     * @param Request $request request
     * @return null
     */
    public function destroyAuto(Request $request)
    {
        if (Auth::guest() === true) {
            return null;
        }

        if ($draft = XeDraft::getAuto($request->get('key'))) {
            XeDraft::remove($draft);
        }
    }
}
