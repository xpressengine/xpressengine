<?php
/**
 * This file is open graph importer.
 *
 * PHP version 5
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Seo\Importers;

/**
 * OpenGraphImporter class
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class OpenGraphImporter extends AbstractImporter
{
    /**
     * meta items
     *
     * @var array
     */
    protected $metaItems = [
        'type' => 'og:type',
        'url' => 'og:url',
        'siteName' => 'og:site_name',
        'title' => 'og:title',
        'description' => 'og:description',
        'author' => 'og:article:author',
        'images' => 'og:image',
    ];

    /**
     * will be cut items name and length
     *
     * @var array
     */
    protected $cuts = [
        'description' => 100
    ];

    /**
     * items of need prepend host
     *
     * @var array
     */
    protected $needHost = ['url', 'images'];
}
