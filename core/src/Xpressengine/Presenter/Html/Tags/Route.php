<?php
/**
 * Rule
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

use Illuminate\Routing\Route as Router;

/**
 * Rule
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Route
{
    use EmptyStringTrait;

    /**
     * @var routes[]
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
     * @param array  $route    route
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
    public static function init ()
    {
    }

    /**
     * route 출력
     *
     * @return string
     */
    public static function output()
    {
        $output = sprintf(
            'XE.Router.addRoutes(%s);',
            json_enc(static::$routes)
        );
        return $output;
    }
}
