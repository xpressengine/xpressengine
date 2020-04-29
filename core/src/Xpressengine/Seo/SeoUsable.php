<?php
/**
 * This file is search engine optimizer usable interface.
 *
 * PHP version 7
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Seo;

/**
 * SeoUsable interface
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
