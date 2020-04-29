<?php
/**
 * This file is MimeTypeFilter trait
 *
 * PHP version 7
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media;

/**
 * Trait MimeTypeFilter
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait MimeTypeFilter
{
    /**
     * MimeTypeScope instance
     *
     * @var MimeTypeScope
     */
    protected static $mimeTypeScope;

    /**
     * Boot the mime type filter trait for a model.
     *
     * @return void
     */
    public static function bootMimeTypeFilter()
    {
        static::addGlobalScope(static::getMimeTypeScope());
    }

    /**
     * Returns the mime type filter scope
     *
     * @return MimeTypeScope
     */
    public static function getMimeTypeScope()
    {
        if (!static::$mimeTypeScope) {
            static::$mimeTypeScope = new MimeTypeScope;
        }

        return static::$mimeTypeScope;
    }
}
