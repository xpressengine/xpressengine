<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin\Exceptions;

use Xpressengine\Plugin\PluginException;

/**
 * PluginFileNotFoundException Class
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 */
class PluginFileNotFoundException extends PluginException
{
    protected $message = 'xe::pluginNotFound';
}
