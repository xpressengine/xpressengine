<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use XePresenter;

class TagController extends Controller
{
    protected $tag;

    public function __construct()
    {
        $this->tag = \App::make('xe.tag');
    }

    public function autoComplete()
    {
        $terms = $this->tag->autoCompletion(\Input::get('string'));

        $words = [];
        foreach ($terms as $tagEntity) {
            $words[] = $tagEntity->word;
        }

        return XePresenter::makeApi($words);
    }
}

