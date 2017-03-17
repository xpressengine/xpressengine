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
        'image' => 'og:image',
        'image_width' => 'og:image:width',
        'image_height' => 'og:image:height'
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
    protected $needHost = ['url', 'image'];


    /**
     * Execute import job
     *
     * @param array $data data array
     * @return void
     */
    public function exec(array $data)
    {
        if (isset($data['images'])) {
            $images = $data['images'];
            unset($data['images']);
        }

        parent::exec($data);

        if (isset($images)) {
            foreach ($images as $image) {
                $this->addMeta('image', $image['url']);
                if (isset($image['width'])) {
                    $this->addMeta('image_width', $image['width']);
                }
                if (isset($image['height'])) {
                    $this->addMeta('image_height', $image['height']);
                }
            }
        }
    }
}
