<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
