<?php
/**
 * Class EmptyLocaleException
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Translation\Exceptions;

use Xpressengine\Translation\TranslationException;

/**
 * locale 목록이 비어있는 경우
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 */
class EmptyLocaleException extends TranslationException
{
    protected $message = 'locale 목록이 비어있습니다.';
}
