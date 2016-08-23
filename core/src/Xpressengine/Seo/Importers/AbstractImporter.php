<?php
/**
 * This file is abstract importer.
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

use Illuminate\Http\Request;
use Xpressengine\Presenter\Html\FrontendHandler;
use Illuminate\Support\Str;

/**
 * AbstractImport class
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractImporter
{
    /**
     * FrontendHandler instance
     *
     * @var FrontendHandler
     */
    protected $frontend;

    /**
     * Request instance
     *
     * @var Request
     */
    protected $request;

    /**
     * meta items
     *
     * @var array
     */
    protected $metaItems = [];

    /**
     * will be cut items name and length
     *
     * @var array
     */
    protected $cuts = [];

    /**
     * items of need prepend host
     *
     * @var array
     */
    protected $needHost = [];

//    private static $counter = 0;

    /**
     * Constructor
     *
     * @param FrontendHandler $frontend FrontendHandler instance
     * @param Request         $request  Request instance
     */
    public function __construct(FrontendHandler $frontend, Request $request)
    {
        $this->frontend = $frontend;
        $this->request = $request;
    }

    /**
     * Execute import job
     *
     * @param array $data data array
     * @return void
     */
    public function exec(array $data)
    {
        $data['url'] = $this->extractUrl($data);

        foreach ($this->metaItems as $key => $name) {
            if (isset($data[$key]) !== true) {
                continue;
            }

            if($key === 'images') {
                foreach($data[$key] as &$image) {
                    $image = $image['url'];
                }
            }

            $this->addMeta($key, $data[$key]);
        }
    }

    /**
     * Extract url from data array
     *
     * @param array $data data array
     * @return string
     */
    protected function extractUrl(array $data)
    {
        return isset($data['url']) ? $data['url'] : $this->request->fullUrl();
    }

    /**
     * Add meta tag
     *
     * @param string       $key      item key
     * @param string|array $contents meta content
     * @return void
     */
    protected function addMeta($key, $contents)
    {
        $contents = (array) $contents;

        foreach ($contents as $content) {
            $content = array_key_exists($key, $this->cuts) ? $this->substr($content, $this->cuts[$key]) : $content;
            $content = in_array($key, $this->needHost) ? $this->prependHost($content) : $content;

//            $this->frontend->meta($this->makeName())
            $this->frontend->meta()
                ->property($this->metaItems[$key])
                ->content($content)
                ->load();
        }
    }

    /**
     * Substr
     *
     * @param string $origin origin text
     * @param int    $len    cut length
     * @return string
     */
    protected function substr($origin, $len)
    {
        $text = Str::substr($origin, 0, $len);

        return $origin == $text ? $text : $text . '...';
    }

    /**
     * prepend host to url path
     *
     * @param string $url url path
     * @return string
     */
    protected function prependHost($url)
    {
        if (preg_match('/^(http[s]?\:\/\/)([^\/]+)/i', $url, $matches) === 0) {
            return $this->request->root() . '/' . ltrim($url, '/');
        }

        return $url;
    }

//    private function makeName()
//    {
//        return 'seo_meta_' . self::$counter++;
//    }
}
