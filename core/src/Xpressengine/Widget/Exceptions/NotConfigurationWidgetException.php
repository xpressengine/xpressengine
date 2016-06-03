<?php
/**
 * NotConfigurationWidgetException
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Widget\Exceptions;

use Exception;
use Xpressengine\Widget\WidgetException;

/**
 * NotConfigurationWidgetException
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 */
class NotConfigurationWidgetException extends WidgetException
{
    protected $message = '위젯이 설정되지 않았습니다 ';
}
