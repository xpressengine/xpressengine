<?php
/**
 * This file is search engine optimizer usable interface.
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Seo;

/**
 * SeoUsable interface
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface SeoUsable
{
    /**
     * Returns title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Returns description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Returns keyword
     *
     * @return string|array
     */
    public function getKeyword();

    /**
     * Returns url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Returns author
     *
     * @return string
     */
    public function getAuthor();

    /**
     * Returns image url list
     *
     * @return array
     */
    public function getImages();
}
