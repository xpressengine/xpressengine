<?php
namespace Xpressengine\Tests\Plugin\Sample;

class BoardManager
{

    /**
     * @var BoardManager
     */
    static protected $singleton;

    static public function getInstance()
    {
        return self::$singleton = new static();
    }

    final private function __construct()
    {

    }

    public function getIndex()
    {
        return \View::make('hello');
    }

    public function getList()
    {
        $page = \Input::get('page');
        return 'hi, Global Board List. Page '.$page;
    }
}
