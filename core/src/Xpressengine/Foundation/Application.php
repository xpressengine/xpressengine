<?php
/**
 * Application.php
 *
 * PHP version 7
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

/**
 * Class Application
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Application extends BaseApplication
{
    /**
     * The custom public path defined by the developer.
     *
     * @var string
     */
    protected $publicPath;

    /**
     * The installed version of XE.
     *
     * @var string
     */
    protected $installedVersion;

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->publicPath ?: $this->basePath;
    }

    /**
     * Set the public directory.
     *
     * @param string $path path for the public
     * @return $this
     */
    public function usePublicPath($path)
    {
        $this->publicPath = $path;

        $this->instance('path.public', $path);

        return $this;
    }

    /**
     * Get the path to the plugins directory.
     *
     * @return string
     */
    public function pluginsPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'plugins';
    }

    /**
     * Get the path to the private plugins directory.
     *
     * @return string
     */
    public function privatesPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'privates';
    }

    /**
     * Get the path to the proxies directory.
     *
     * @return string
     */
    public function proxiesPath()
    {
        return $this->storagePath().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'interception';
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        parent::bindPathsInContainer();

        $this->instance('path.plugins', $this->pluginsPath());
        $this->instance('path.privates', $this->privatesPath());
        $this->instance('path.proxies', $this->proxiesPath());
    }

    /**
     * Get the path to the cached plugins.php file.
     *
     * @return string
     */
    public function getCachedPluginsPath()
    {
        return $this->bootstrapPath().'/cache/plugins.php';
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        parent::registerCoreContainerAliases();

        $this->alias('app', self::class);
        $this->alias('request', \Xpressengine\Http\Request::class);
    }

    /**
     * Returns the installed version of XE.
     *
     * @return null|string
     */
    public function getInstalledVersion()
    {
        if (!$this->installedVersion) {
            if (!file_exists($path = $this->getInstalledPath())) {
                return null;
            }

            $this->installedVersion = trim(file_get_contents($path));
        }

        return $this->installedVersion;
    }

    /**
     * Returns the file path for determine if installed.
     *
     * @return string
     */
    public function getInstalledPath()
    {
        return $this->storagePath().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'installed';
    }
}
