<?php
/**
* EditorNotFoundException
*
* PHP version 5
*
* @category    Editor
* @package     Xpressengine\Editor
* @author      XE Team (developers) <developers@xpressengine.com>
* @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
* @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
* @link        http://www.xpressengine.com
*/
namespace Xpressengine\Editor\Exceptions;

use Xpressengine\Editor\EditorException;

/**
* EditorNotFoundException
*
* @category    Editor
* @package     Xpressengine\Editor
* @author      XE Team (developers) <developers@xpressengine.com>
* @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
* @link        http://www.xpressengine.com
*/
class EditorNotFoundException extends EditorException
{
    protected $message = 'Editor not founded.';
}
