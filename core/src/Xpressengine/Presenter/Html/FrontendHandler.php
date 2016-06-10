<?php
/**
 * FrontendHandler
 *
 * PHP version 5
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html;

/**
 * FrontendHandler
 *
 * FrontendHandler는 html 문서가 출력할 때 필요한 다양한
 * 태그와js, css파일을 지정된 위치에 추가하고 관리하는 역할을 합니다.
 * FrontendHandler는 현재 9가지 형태의 태그를 지원합니다.
 *
 * ## 브라우저 타이틀 태그 지정하기
 *
 * `title` 메소드를 사용하십시오.
 *
 * ```php
 * XeFrontend::title('브라우저 타이틀입니다');
 * ```
 * ## body 태그의 class 지정하기
 *
 * `bodyClass` 메소드를 사용하십시오.
 *
 * ```php
 * // body에 'profile' class지정
 * XeFrontend::bodyClass('profile');
 * ```
 *
 * ## js 파일 로드하기
 *
 * ### 기본 사용법
 *
 * `js` 메소드를 사용하여 스크립트 파일을 로드할 수 있습니다.
 * 이때, `appendTo`, `prependTo` 메소드를 사용하면, 로드하는 위치를
 * `<head>`, `<body>` 태그 내에 위치시킬 수 있습니다.
 * 반드시 마지막에는 `load` 메소드를 사용해야 합니다.
 *
 * ```php
 * // xe.js파일을 head의 하단에 로드함.
 * XeFrontend::js('assets/core/common/js/xe.js')->appendTo('head')->load();
 *
 * // xe.js파일을 body의 상단에 로드함.
 * XeFrontend::js('assets/core/common/js/xe.js')->prependTo('body')->load();
 * ```
 *
 * ### 우선순위 지정
 *
 * 만약 스크립트 파일을 로드할 때, 반드시 먼저 로드돼야 하는
 * 다른 스크립트 파일이 있다면 `before` 메소드를 사용하여 지정할 수 있습니다.
 * 반대의 경우, `after` 메소드를 사용하십시오.
 *
 * ```php
 * // bootstrap.js이 로드된 이후에 xe.js파일이 로드되도록 우선순위 지정
 * XeFrontend::js('assets/core/common/js/xe.js')
 * ->before('assets/vendor/bootstrap/js/bootstrap.js')
 * ->appendTo('body')->load();
 * ```
 *
 * ### 언로드
 *
 * 이미 로드된 스크립트 파일이라도 `unload` 메소드를 사용하여 언로드할 수 있습니다.
 *
 * ```php
 * // 로드된 xe.js파일을 언로드함.
 * XeFrontend::js('assets/core/common/js/xe.js')->unload();
 * ```
 *
 * ## css 파일 로드하기
 *
 * css 파일도 js 스크립트 파일과 사용법이 동일합니다.
 * 단 `appendTo`, `prependTo` 메소드를 지원하지 않습니다.
 *
 * ```php
 * // xe.css파일을 로드함. 반드시 bootstrap.css가 로드된 다음에 로드되도록 우선순위를 지정
 * XeFrontend::js('assets/core/common/css/xe.css')->appendTo('body')->before('assets/vendor/bootstrap.css')->load();
 * ```
 *
 * ## meta 태그 추가
 *
 * `meta` 메소드를 사용하여 meta 태그를 지정할 수 있습니다.
 * meta 태그의 attribute를 지정하기 위해
 * `name`, `charset`, `property`, `httpEquiv`, `content`를 지원합니다.
 *
 * ```php
 * // 등록하려는 meta 태그의 별칭 등록.
 * $alias = 'my.viewport';
 *
 * XeFrontend::meta($alias)->name('viewport')
 * ->content('width=device-width, initial-scale=1.0')->load();
 * ```
 *
 * > `alias`는 다른 곳에서 내가 입력한 meta 태그를 언로드할 때 key로 사용합니다.
 *
 * ## custom html 태그 추가하기
 *
 * `html` 메소드를 사용하면 자유롭게 원하는 코드를 추가할 수 있습니다.
 *
 * ```php
 * $alias = 'myscript';
 *
 * // script 코드를 `<body>` 하단에 추가
 * XeFrontend::html($alias)->content('
 * <script>
 *     $(function () {
 *         $('[data-toggle="tooltip"]').tooltip()
 *     })
 * </script>
 * ')->appendTo('body')->load();
 * ```
 *
 * `unload`, `before`
 *
 * ## icon 파일 로드하기
 *
 * `icon` 메소드를 사용할 수 있습니다.
 *
 * ```php
 * XeFrontend::icon($iconUrl)->load();
 * ```
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
 * @method Tags\Package package($name) custom package tag를 추가한다.
 * @method Tags\Rule rule($ruleName, $rules) validation rule을 추가한다.
 * @method Tags\Translation translation($keys) javascript에서 사용할 다국어를 추가한다.
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
