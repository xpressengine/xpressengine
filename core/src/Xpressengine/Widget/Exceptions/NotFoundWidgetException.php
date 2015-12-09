<?php
/**
 * NotFoundWidgetException
 *
 * PHP version 5
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Widget\Exceptions;

use Exception;
use Xpressengine\Widget\WidgetException;

/**
 * NotFoundWidgetException
 *
 * PHP version 5
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class NotFoundWidgetException extends WidgetException
{
    protected $message = '위젯을 찾을 수 없습니다.';
}
