<?php
namespace App\Http\Controllers;

use Auth;
use Input;
use XeTemporary;
use XePresenter;

class TemporaryController extends Controller
{
    public function index()
    {
        if (Auth::guest() !== true) {
            $temporaries = XeTemporary::get(Input::get('key'));

            if (!empty($temporaries)) {
                uasort($temporaries, function ($a, $b) {
                    if ($a->createdAt == $b->createdAt) {
                        return 0;
                    }
                    return ($a->createdAt < $b->createdAt) ? 1 : -1;
                });
            }

            return XePresenter::makeApi($temporaries);
        }
    }

    public function store()
    {
        if (Auth::guest() !== true) {
            try {
                $etc = Input::except(['_token', 'key', 'rep']);
                $temporary = XeTemporary::set(Input::get('key'), Input::get(Input::get('rep')), $etc);
            } catch (\Exception $e) {
                echo $e->getMessage() . '|' . $e->getFile() . '|' . $e->getLine();

                throw $e;
            }

            return XePresenter::makeApi(['temporaryId' => $temporary->id]);
        }

        return XePresenter::makeApi(['temporaryId' => null]);
    }

    public function update($temporaryId)
    {
        if (Auth::guest() !== true) {
            if (($old = XeTemporary::getById($temporaryId)) && $old->userId == Auth::user()->getId()) {
                $etc = Input::except(['_token', 'rep']);
                $temporary = XeTemporary::put($temporaryId, Input::get(Input::get('rep')), $etc);

                return XePresenter::makeApi(['temporaryId' => $temporary->id]);
            }
        }

        return XePresenter::makeApi(['temporaryId' => null]);
    }

    public function destroy($temporaryId)
    {
        if (Auth::guest() !== true) {
            if ($temporary = XeTemporary::getById($temporaryId)) {
                if (Auth::user()->getId() == $temporary->userId) {
                    XeTemporary::remove($temporary);
                }
            }
        }

        return XePresenter::makeApi(['result' => true]);
    }

    public function setAuto()
    {
        if (Auth::guest() === true) {
            return null;
        }

        $etc = Input::except(['_token', 'key', 'rep']);

        if ($temporary = XeTemporary::getAuto(Input::get('key'))) {
            XeTemporary::put($temporary->id, Input::get(Input::get('rep')), $etc);
        } else {
            XeTemporary::set(Input::get('key'), Input::get(Input::get('rep')), $etc, true);
        }
    }

    public function destroyAuto()
    {
        if (Auth::guest() === true) {
            return null;
        }

        if ($temporary = XeTemporary::getAuto(Input::get('key'))) {
            XeTemporary::remove($temporary);
        }
    }
}
