<?php
namespace App\Http\Controllers;

use Auth;
use Input;
use Temporary;
use Presenter;

class TemporaryController extends Controller
{
    public function index()
    {
        if (Auth::guest() !== true) {
            $temporaries = Temporary::get(Input::get('key'));

            if (!empty($temporaries)) {
                uasort($temporaries, function ($a, $b) {
                    if ($a->createdAt == $b->createdAt) {
                        return 0;
                    }
                    return ($a->createdAt < $b->createdAt) ? 1 : -1;
                });
            }

            return Presenter::makeApi($temporaries);
        }
    }

    public function store()
    {
        if (Auth::guest() !== true) {
            try {
                $etc = Input::except(['_token', 'key', 'rep']);
                $temporary = Temporary::set(Input::get('key'), Input::get(Input::get('rep')), $etc);
            } catch (\Exception $e) {
                echo $e->getMessage() . '|' . $e->getFile() . '|' . $e->getLine();

                throw $e;
            }

            return Presenter::makeApi(['temporaryId' => $temporary->id]);
        }

        return Presenter::makeApi(['temporaryId' => null]);
    }

    public function update($temporaryId)
    {
        if (Auth::guest() !== true) {
            if (($old = Temporary::getById($temporaryId)) && $old->userId == Auth::user()->getId()) {
                $etc = Input::except(['_token', 'rep']);
                $temporary = Temporary::put($temporaryId, Input::get(Input::get('rep')), $etc);

                return Presenter::makeApi(['temporaryId' => $temporary->id]);
            }
        }

        return Presenter::makeApi(['temporaryId' => null]);
    }

    public function destroy($temporaryId)
    {
        if (Auth::guest() !== true) {
            if ($temporary = Temporary::getById($temporaryId)) {
                if (Auth::user()->getId() == $temporary->userId) {
                    Temporary::remove($temporary);
                }
            }
        }

        return Presenter::makeApi(['result' => true]);
    }

    public function setAuto()
    {
        if (Auth::guest() === true) {
            return null;
        }

        $etc = Input::except(['_token', 'key', 'rep']);

        if ($temporary = Temporary::getAuto(Input::get('key'))) {
            Temporary::put($temporary->id, Input::get(Input::get('rep')), $etc);
        } else {
            Temporary::set(Input::get('key'), Input::get(Input::get('rep')), $etc, true);
        }
    }

    public function destroyAuto()
    {
        if (Auth::guest() === true) {
            return null;
        }

        if ($temporary = Temporary::getAuto(Input::get('key'))) {
            Temporary::remove($temporary);
        }
    }
}
