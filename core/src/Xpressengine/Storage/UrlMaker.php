<?php
/**
 * This file is generate file url.
 *
 * PHP version 7
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Storage;

use Closure;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * UrlMaker class
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UrlMaker
{
    /**
     * UrlGenerator instance
     *
     * @var UrlGenerator
     */
    protected $urlGenerator;

    /**
     * Disk config array
     *
     * @var array
     */
    protected $config;

    /**
     * Route name
     *
     * @var string
     */
    protected $routeName = 'file.path';

    /**
     * Constructor
     *
     * @param UrlGenerator $urlGenerator UrlGenerator instance
     * @param array        $config       Disk config array
     */
    public function __construct(UrlGenerator $urlGenerator, array $config)
    {
        $this->urlGenerator = $urlGenerator;
        $this->config = $config;
    }

    /**
     * get url src
     *
     * @param File    $file     file instance
     * @param Closure $callback callback function
     * @return string
     */
    public function url(File $file, Closure $callback = null)
    {
        $url = $this->getUrl($file) ?: $this->route($file);

        if ($callback !== null) {
            call_user_func_array($callback, [$file, &$url]);
        }

        return $url;
    }

    /**
     * get route src
     *
     * @param File $file file instance
     * @return string
     */
    public function route(File $file)
    {
        return $this->urlGenerator->route($this->routeName, ['id' => $file->id]);
    }

    /**
     * get file url path
     *
     * @param File $file file instance
     * @return string
     */
    protected function getUrl(File $file)
    {
        $config = $this->getConfig($file->disk);

        if (isset($config['url']) === true) {
            return $this->urlGenerator->asset(
                rtrim($config['url'], '/') . '/' . ltrim($file->getPathname(), '/')
            );
        }

        return null;
    }

    /**
     * get storage disk config
     *
     * @param string $name disk name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->config[$name];
    }

    /**
     * Get route name
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Set route name
     *
     * @param string $name route name
     * @return void
     */
    public function setRouteName($name)
    {
        $this->routeName = $name;
    }
}
