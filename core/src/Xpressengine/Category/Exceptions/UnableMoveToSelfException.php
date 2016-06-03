<?php
/**
 * This file is unable move to self exception.
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Category\Exceptions;

use Xpressengine\Category\CategoryException;

/**
 * 자신으로 이동 불가 예외 클래스
 *
 * @category    Category
 * @package     Xpressengine\Category
 */
class UnableMoveToSelfException extends CategoryException
{
    protected $message = '자기 자신으로 이동할 수 없습니다.';
}
