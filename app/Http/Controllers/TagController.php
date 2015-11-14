<?php
namespace App\Http\Controllers;

use Presenter;

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

        return Presenter::makeApi($words);
    }
}

