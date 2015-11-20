<?php
namespace Xpressengine\Tests\Plugin\Sample;

class Board
{

    /**
     * @var Board
     */
    static protected $singleton;

    static public function getInstance()
    {
        return self::$singleton = new static();
    }

    final private function __construct()
    {
    }

    public function getSetting($bid)
    {
        return \View::make('hello');
    }

    public function getList($bid)
    {

        if ($bid === null) {
            return 'bid가 없네...';
        }

        return 'hi, '.$bid;
    }

    public function getWrite($bid)
    {
        return 'write post!';
    }
}
