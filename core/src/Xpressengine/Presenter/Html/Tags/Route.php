<?php
/**
 * Rule
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
 * Rule
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Route
{
    use EmptyStringTrait;

    /**
     * @var \Illuminate\Routing\Route[]
     */
    protected static $routes = [];

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var string
     */
    public $uri;

    /**
     * @var array
     */
    public $methods = [];

    /**
     * @var array
     */
    public $params = [];

    /**
     * create instance
     *
     * @param string $routeName route 이름
     * @param array  $route     route
     *
     * @throws \Exception
     */
    public function __construct($routeName, $route)
    {
        $this->routeName = $routeName;
        $this->uri = $route['uri'];
        $this->methods = $route['methods'];
        $this->params = $route['params'];

        static::$routes[$routeName] = $this;
    }

    /**
     * init
     *
     * @return void
     */
    public static function init()
    {
    }

    /**
     * route 반환
     *
     * @return array
     */
    public static function getRoutes()
    {
        return json_dec(json_enc(self::$routes));
    }

    /**
     * route 출력
     *
     * @return string
     */
    public static function output()
    {
        return json_enc(static::$routes);
    }
}
