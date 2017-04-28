<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Auth;
use XeDraft;
use XePresenter;
use Xpressengine\Http\Request;

class DraftController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guest() !== true) {
            $drafts = XeDraft::get($request->get('key'));

            if (!empty($drafts)) {
                uasort($drafts, function ($a, $b) {
                    if ($a->createdAt == $b->createdAt) {
                        return 0;
                    }
                    return ($a->createdAt < $b->createdAt) ? 1 : -1;
                });
            }

            return XePresenter::makeApi($drafts);
        }
    }

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

    public function update(Request $request, $draftId)
    {
        if (Auth::guest() !== true) {
            if (($old = XeDraft::getById($draftId)) && $old->userId == Auth::user()->getId()) {
                $etc = $request->except(['_token', 'rep']);
                $draft = XeDraft::put($draftId, $request->get($request->get('rep')), $etc);

                return XePresenter::makeApi(['draftId' => $draft->id]);
            }
        }

        return XePresenter::makeApi(['draftId' => null]);
    }

    public function destroy($draftId)
    {
        if (Auth::guest() !== true) {
            if ($draft = XeDraft::getById($draftId)) {
                if (Auth::user()->getId() == $draft->userId) {
                    XeDraft::remove($draft);
                }
            }
        }

        return XePresenter::makeApi(['result' => true]);
    }

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
