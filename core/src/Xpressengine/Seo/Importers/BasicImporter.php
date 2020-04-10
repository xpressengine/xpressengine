<?php
/**
 * This file is basic importer.
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
 * BasicImporter class
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class BasicImporter extends AbstractImporter
{
    /**
     * meta items
     *
     * @var array
     */
    protected $metaItems = [
        'keywords' => 'keywords',
        'description' => 'description',
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
     * Execute import job
     *
     * @param array $data data array
     * @return void
     */
    public function exec(array $data)
    {
        $url = $this->extractUrl($data);

        $this->frontend->html('canonical')->content($this->makeCanonical($url))->prependTo('head')->load();

        parent::exec($data);
    }

    /**
     * Make canonical tag
     *
     * @param string $url url path
     * @return string
     */
    protected function makeCanonical($url)
    {
        return '<link rel="canonical" href="' . $this->prependHost($url) . '" />';
    }
}
