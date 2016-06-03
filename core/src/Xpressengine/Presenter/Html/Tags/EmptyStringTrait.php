<?php
/**
 * EmptyStringTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

/**
 * EmptyStringTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 */
trait EmptyStringTrait
{
    /**
     * to string
     *
     * @return string
     */
    function __toString()
    {
        return '';
    }
}
