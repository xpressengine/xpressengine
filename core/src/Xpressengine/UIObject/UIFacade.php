<?php namespace Xpressengine\UIObject;

use Illuminate\Support\Facades\Facade;

/**
 * Class UIFacade
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Team (develop) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UIFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.uiobject';
    }
}
