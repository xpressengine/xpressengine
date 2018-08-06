<?php
/**
 * ParameterTrait.php
 *
 * PHP version 7
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

/**
 * trait ParameterTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
     * @param string $file file path
     * @return string
     */
    protected function buildSource($file)
    {
        if (count($this->parameters) < 1) {
            return $file;
        }

        return $file . '?' . http_build_query($this->parameters);
    }
}
