<?php
/**
* EditorNotFoundException
*
* PHP version 7
*
* @category    Editor
* @package     Xpressengine\Editor
* @author      XE Team (developers) <developers@xpressengine.com>
* @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
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
