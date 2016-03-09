<?php
/**
 * This file is MimeTypeFilter trait
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Media;

/**
 * Trait MimeTypeFilter
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
