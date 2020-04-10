<?php
/**
 * This file is abstract importer.
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

use Illuminate\Http\Request;
use Xpressengine\Presenter\Html\FrontendHandler;
use Illuminate\Support\Str;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * AbstractImport class
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * property used meta items
     *
     * @var array
     */
    protected $properties = [];

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

    /**
     * UrlGenerator instance
     *
     * @var UrlGenerator $urlGenerator
     */
    protected static $urlGenerator;

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

            if ($key === 'images') {
                foreach ($data[$key] as &$image) {
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
        $url = isset($data['url']) ? $data['url'] : $this->request->fullUrl();

        return htmlspecialchars($url, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * Add meta tag
     *
     * @param string       $key      item key
     * @param string|array $contents meta content
     * @param int          $sequence sequence number
     * @return void
     */
    protected function addMeta($key, $contents, $sequence = 0)
    {
        $contents = (array) $contents;

        foreach ($contents as $content) {
            $content = array_key_exists($key, $this->cuts) ? $this->substr($content, $this->cuts[$key]) : $content;

            if ($key === 'url') {
                $content = $this->prependHost($content, false);
            } elseif (in_array($key, $this->needHost)) {
                $content = $this->prependHost($content);
            }

            $alias = $sequence ? $this->metaItems[$key] . $sequence : $this->metaItems[$key];
            if (in_array($key, $this->properties)) {
                $this->frontend->meta($alias)
                    ->property($this->metaItems[$key])
                    ->content($content)
                    ->load();
            } else {
                $this->frontend->meta($alias)
                    ->name($this->metaItems[$key])
                    ->content($content)
                    ->load();
            }
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
     * @param string  $url     url path
     * @param boolean $isAsset given param is the asset
     * @return string
     */
    protected function prependHost($url, $isAsset = true)
    {
        return $isAsset ? static::$urlGenerator->asset($url) : static::$urlGenerator->to($url);
    }

    /**
     * Set url generator instance
     *
     * @param UrlGenerator $urlGenerator UrlGenerator instance
     * @return void
     */
    public static function setUrlGenerator(UrlGenerator $urlGenerator)
    {
        static::$urlGenerator = $urlGenerator;
    }

    /**
     * Get url generator instance
     *
     * @return UrlGenerator
     */
    public static function getUrlGenerator()
    {
        return static::$urlGenerator;
    }
}
