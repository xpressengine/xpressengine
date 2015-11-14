<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Tests\Member;

class TestEntity
{
    public $attr = [];

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    function __construct($attr)
    {
        $this->attr = $attr;
    }

    function __set($key, $value)
    {
        $this->attr[$key] = $value;
    }

    function __get($key)
    {
        return isset($this->attr[$key]) ? $this->attr[$key] : null;
    }

    function diff()
    {
        return ['a' => 'b1', 'c' => 'd1'];
    }

    public function getAttributes()
    {
        return $this->attr;
    }

    public function syncOriginal()
    {
    }
}
