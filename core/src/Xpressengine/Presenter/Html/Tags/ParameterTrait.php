<?php
/**
 * ParameterTrait.php
 *
 * PHP version 7
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

/**
 * trait ParameterTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait ParameterTrait
{
    /**
     * The parameters
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Set parameters
     *
     * @param string|array $key   key
     * @param string|null  $value value
     * @return $this
     */
    public function param($key, $value = null)
    {
        if (is_array($key)) {
            $this->parameters = array_merge($this->parameters, $key);
        } else {
            $this->parameters[$key] = $value;
        }

        return $this;
    }

    /**
     * Build file source
     *
     * @param string $file file url
     * @return string
     */
    protected function buildSource($file)
    {
        $time = $this->mtime($file);

        if (count($this->parameters) < 1) {
            return $file.($time ? '?'.$time : '');
        }

        return $file.'?'.http_build_query($this->parameters).($time ? '&'.$time : '');
    }

    /**
     * Returns the modification time for given file
     *
     * @param string $file file url
     * @return bool|int|null
     */
    protected function mtime($file)
    {
        if (!$path = $this->findFile($file)) {
            return null;
        }

        return filemtime($path);
    }

    /**
     * Returns the real path for given file.
     *
     * @param string $file file url
     * @return bool|null|string
     */
    protected function findFile($file)
    {
        if (!$parse = parse_url($file)) {
            return null;
        }
        if (!isset($parse['host']) || request()->getHost() !== $parse['host'] || !isset($parse['path'])) {
            return null;
        }

        if ($path = realpath(public_path($parse['path']))) {
            return $path;
        }

        $segments = explode('/', $parse['path']);
        $items = [];
        foreach ($segments as $segment) {
            if (!$segment || $segment === '.') {
                continue;
            }
            if ($segment === '..') {
                array_pop($items);
            } else {
                $items[] = $segment;
            }
        }
        $path = public_path(implode('/', $items));

        return file_exists($path) ? $path : null;
    }
}
