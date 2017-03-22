<?php
/**
 * EmptyStringTrait
 *
 * PHP version 5
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
    public function __toString()
    {
        return '';
    }
}
