<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

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
