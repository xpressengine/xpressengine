<?php
/**
 * FrontendHandler
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

namespace Xpressengine\Presenter\Html;

/**
 * FrontendHandler는 html 문서가 출력할 때 필요한 다양한 태그와js, css파일을 지정된 위치에 추가하고 관리하는 역할을 합니다.
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @method Tags\Title title($title) browser title을 입력한다.
 * @method Tags\Meta meta() meta tag를 추가한다.
 * @method Tags\IconFile icon($file) browser icon을 추가한다.
 * @method Tags\CSSFile css($files) css 파일을 추가한다.
 * @method Tags\JSFile js($files) js 파일을 추가한다.
 * @method Tags\BodyClass bodyClass($class) body 태그에 class를 추가한다.
 * @method Tags\Html html($alias) custom html tag를 추가한다.
 * @method Tags\Rule rule($ruleName, $rules) validation rule을 추가한다.
 * @method Tags\Translation translation($keys) javascript에서 사용할 다국어를 추가한다.
 * @method Tags\Preload preload($keys) preload resources
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FrontendHandler
{
    /**
     * @var array
     */
    protected $tags;

    /**
     * create instance
     *
     * @param array $tags tags
     */
    public function __construct($tags = [])
    {
        foreach ($tags as $class) {
            $class::init();
        }
        $this->tags = $tags;
    }

    /**
     * add tag
     *
     * @param string      $name  name
     * @param null|string $class class name
     * @return void
     */
    public function addTag($name, $class = null)
    {
        if ($class !== null) {
            $name = [$name => $class];
        }

        $this->tags = array_merge($this->tags, $name);
    }

    /**
     * output
     *
     * @return mixed|void
     */
    public function output()
    {
        $args = func_get_args();
        $name = array_shift($args);

        if (!isset($this->tags[$name])) {
            // TODO: throw Exception
            return;
        }

        $class = $this->tags[$name];

        return forward_static_call_array([$class, 'output'], $args);
    }

    /**
     * call magic method
     *
     * @param string $name      name
     * @param array  $arguments arguments
     * @return object|void
     */
    public function __call($name, array $arguments)
    {

        if (!isset($this->tags[$name])) {
            throw new \BadMethodCallException();
        }

        $class = $this->tags[$name];

        $reflect  = new \ReflectionClass($class);
        $instance = $reflect->newInstanceArgs($arguments);

        return $instance;
    }
}
