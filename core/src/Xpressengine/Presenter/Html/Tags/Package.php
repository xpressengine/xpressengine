<?php
/**
 *  Package
 *
 * PHP version 5
 *
 * @category    Presenter\Html|Tags
 * @package     Xpressengine\Presenter\Html|Tags
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Presenter\Html\Tags;

use Closure;
use Xpressengine\Presenter\Exceptions\PackageNotFoundException;
use Xpressengine\Presenter\Html\FrontendHandler;

/**
 * Package
 *
 * @category    Presenter\Html|Tags
 * @package     Xpressengine\Presenter\Html|Tags
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Package
{
    /**
     * @var array
     */
    protected static $packages = [];

    /**
     * @var string
     */
    protected $name;

    /**
     * @var FrontendHandler
     */
    protected static $handler;

    /**
     * init
     *
     * @param array $packages packages
     *
     * @return void
     */
    public static function init($packages = [])
    {
        self::$packages = $packages;
    }

    /**
     * packages
     *
     * @return array
     */
    public static function packages()
    {
        return self::$packages;
    }

    /**
     * Package constructor.
     *
     * @param string $name name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * set handler
     *
     * @param FrontendHandler $handler frontend handler
     * @return void
     */
    public static function setHandler($handler)
    {
        self::$handler = $handler;
    }

    /**
     * register package
     *
     * @param Closure $callback callback
     *
     * @return static $this
     */
    public function register(Closure $callback)
    {
        self::$packages[$this->name] = $callback;
        return $this;
    }

    /**
     * load package
     *
     * @return $this
     */
    public function load()
    {
        /** @var Closure $callback */
        $callback = array_get(self::$packages, $this->name);

        if ($callback === null) {
            throw new PackageNotFoundException(['name' => $this->name]);
        }

        $callback(static::$handler);

        return $this;
    }
}
