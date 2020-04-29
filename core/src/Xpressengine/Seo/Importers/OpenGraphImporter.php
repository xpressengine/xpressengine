<?php
/**
 * This file is open graph importer.
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

namespace Xpressengine\Seo\Importers;

/**
 * OpenGraphImporter class
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * property used meta items
     *
     * @var array
     */
    protected $properties = [
        'type',
        'url',
        'siteName',
        'title',
        'description',
        'author',
        'image',
        'image_width',
        'image_height'
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
    protected $needHost = ['image'];


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
            foreach ($images as $i => $image) {
                $this->addMeta('image', $image['url'], $i);
                if (isset($image['width'])) {
                    $this->addMeta('image_width', $image['width'], $i);
                }
                if (isset($image['height'])) {
                    $this->addMeta('image_height', $image['height'], $i);
                }
            }
        }
    }
}
