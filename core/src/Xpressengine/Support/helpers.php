<?php
/**
 * This file is support helper functions
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

if (function_exists('json_enc') === false) {
    /**
     * Returns the JSON representation of a value
     *
     * @package Xpressengine\Support
     *
     * @param mixed $value   target for encoding
     * @param int   $options json behavior constant
     * @param int   $depth   maximum depth
     *
     * @return string
     */
    function json_enc($value, $options = 0, $depth = 512)
    {
        return Xpressengine\Support\Json::encode($value, $options, $depth);
    }
}

if (function_exists('json_dec') === false) {
    /**
     * Decodes a JSON string
     *
     * @package Xpressengine\Support
     *
     * @param string $string  target for decoding
     * @param bool   $assoc   when true, object be converted to array
     * @param int    $depth   recursion depth
     * @param int    $options decode option, just support 'JSON_BIGINT_AS_STRING'
     *
     * @return mixed
     */
    function json_dec($string, $assoc = false, $depth = 512, $options = 0)
    {
        return Xpressengine\Support\Json::decode($string, $assoc, $depth, $options);
    }
}

if (function_exists('json_format') === false) {
    /**
     * 주어진 json string을 보기 편하게 정리한다.
     *
     * @param  string $json            json string
     * @param  bool   $unescapeUnicode Unescape unicode
     * @param  bool   $unescapeSlashes Unescape slashes
     *
     * @return string
     */
    function json_format($json, $unescapeUnicode = true, $unescapeSlashes = true)
    {
        return \Xpressengine\Support\Json::format($json, $unescapeUnicode, $unescapeSlashes);
    }
}

if (function_exists('cast') === false) {
    /**
     * scalar 타입 문자열을 실제 형태로 형변환
     *
     * '1' -> 1, '1.0001' -> 1.0001, 'true' -> true
     *
     * @package Xpressengine\Support
     *
     * @param string $value 대상 문자열
     *
     * @return mixed
     */
    function cast($value)
    {
        return Xpressengine\Support\Caster::cast($value);
    }
}

if (function_exists('bytes') === false) {
    /**
     * 파일 용량을 보기 좋은 형태로 변환
     *
     * @package Xpressengine\Support
     *
     * @param int         $bytes bytes 수치
     * @param null|string $unit  표현 단위
     * @param int         $dec   소수점 이하 표현 갯수
     *
     * @return string
     */
    function bytes($bytes, $unit = null, $dec = 2)
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        if (in_array($unit, $size)) {
            $factor = array_search($unit, $size);
        } else {
            $factor = (int) ((strlen($bytes) - 1) / 3);
        }
        $dec = $factor == 0 ? 0 : $dec;
        if ($factor >= count($size)) {
            $factor = count($size) - 1;
        }

        return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)).$size[$factor];
    }
}

if (! function_exists('xe_redirect')) {
    /**
     * Get an instance of the redirector.
     *
     * @param  string|null $to      url for redirect
     * @param  int         $status  status code
     * @param  array       $headers headers
     * @param  bool        $secure  secure mode
     * @param  array       $data    data
     *
     * @return \Xpressengine\Presenter\RedirectResponse|\Xpressengine\Presenter\Redirector
     */
    function xe_redirect($to = null, $status = 302, $headers = [], $secure = null, array $data = null)
    {
        if (is_null($to)) {
            return app('xe.redirect');
        }

        /** @var \Xpressengine\Presenter\RedirectResponse $redirect */
        $redirect = app('xe.redirect')->to($to, $status, $headers, $secure);
        if ($data !== null) {
            $redirect->setData($data);
        }
        return $redirect;
    }
}

if (function_exists('api_render') === false) {
    /**
     * XE.page() 를 사용하여 호출할 경우 render 된 html 반환
     *
     * @package Xpressengine\Presenter
     *
     * @param string $id           view id
     * @param array  $data         data
     * @param array  $responseData data
     *
     * @return mixed
     */
    function api_render($id, array $data = [], array $responseData = [])
    {
        XePresenter::htmlRenderPartial();

        XePresenter::setId($id);
        XePresenter::setData($data);

        /** @var Xpressengine\Presenter\Html\HtmlPresenter $presenter */
        $presenter = XePresenter::getPresenter('html');
        $presenter->setData();
        $result = $presenter->renderSkin();

        if ($result instanceof \Illuminate\Contracts\Support\Renderable) {
            $result = $result->render();
        }

        return XePresenter::makeApi(
            [
                'result' => (string) $result,
                'data' => $responseData,
            ]
        );
    }
}

if (function_exists('intercept') === false) {
    /**
     * 이 함수는 Xpressengine에서 aop를 사용하기 위해 구현된 함수이다. 이 함수를 사용하여, Proxy가 지정된 특정 클래스의 메소드가 실행될 때,
     * 항상 먼저 실행될 Closure(advice)를 지정할 수 있다.
     * ```
     *  // Document클래스의 insertDocument 메소드가 실행될 때 실행될 Closure 등록
     *  intercept(
     *      'Document@insertDocument',
     *      'spamfilter',
     *      function ($target, $title, $content) {
     *          if($this->checkSpam($content)) {
     *              return $target($title, $content);
     *          } else {
     *              throw new \Exception();
     *          }
     *      }
     *  );
     *
     * ```
     *
     * 또한 다른 advice와의 실행순서를 지정할 수도 있다.
     *
     * ```
     *  // mailsend가 실행된 후, logging이 실행되기 전에 이 advice(spamfilter)를 실행하도록 지정
     *  intercept(
     *      'Document@insertDocument',
     *      ['spamfilter' => ['before'=>'mailsend','after'=>'logging']],
     *      function ($target, $title, $content) {
     *          if($this->checkSpam($content)) {
     *              return $target($title, $content);
     *          } else {
     *              throw new \Exception();
     *          }
     *      }
     *  );
     * ```
     *
     * @package Xpressengine\Interception
     *
     * @param string|string[] $pointCut advice가 실행되기를 바라는 대상 클래스와 메소드, {CLASS명}@{METHOD명}의 형식이어야 한다.
     * @param string|array    $name     advisor의 이름 및 우선순위 지정을 위한 array
     * @param Closure         $advice   실행될 Closure
     *
     * @return void
     */
    function intercept($pointCut, $name, Closure $advice)
    {
        app('xe.interception')->addAdvisor($pointCut, $name, $advice);
    }
}

if (function_exists('xe_trans') === false) {
    /**
     * 다국어 변환
     *
     * @package Xpressengine\Translation
     *
     * @param null  $id         다국어 키
     * @param array $parameters 파라매터
     * @param null  $locale     로케일
     *
     * @return string
     */
    function xe_trans($id = null, $parameters = array(), $locale = null)
    {
        if (is_null($id)) {
            return app('xe.translator');
        }

        try {
            return app('xe.translator')->get($id, $parameters, $locale);
        } catch (Exception $e) {
            return $id;
        }
    }
}

if (function_exists('xe_trans_choice') === false) {
    /**
     * 수량에 의한 다국어 변환
     *
     * @package Xpressengine\Translation
     *
     * @param string $id         다국어 키
     * @param int    $number     숫자
     * @param array  $parameters 파라매터
     * @param null   $locale     로케일
     *
     * @return string
     */
    function xe_trans_choice($id, $number, array $parameters = array(), $locale = null)
    {
        return app('xe.translator')->choice($id, $number, $parameters, $locale);
    }
}

if (function_exists('locale_url') === false) {
    /**
     * locale 변경을 위한 url생성
     *
     * @package Xpressengine\Translation
     *
     * @param string $locale 국가 코드
     * @param array  $params 추가할 파라메터
     * @return string
     */
    function locale_url($locale, array $params = [])
    {
        $request = app('request');
        $queries = $request->query->all();
        if (config('xe.lang.locale_type') === 'route') {
            $url = $request->root().'/'.$locale.'/'.ltrim($request->path(), '/');
        } elseif (config('xe.lang.locale_type') === 'domain') {
            $domains = config('xe.lang.locale_domains');
            if (!isset($domains[$locale])) {
                throw new \Exception("Unknown locale [$locale]");
            }
            $url = $request->getScheme().'://'.$domains[$locale].'/'.ltrim($request->path(), '/');
            array_set($queries, '_s', encrypt(session()->getId()));
        } else {
            $url = $request->url();
            array_set($queries, '_l', $locale);
        }

        $queries = array_merge($queries, $params);

        return $url.(count($queries) > 0 ? '?'.http_build_query($queries) : '');
    }
}

if (function_exists('uio') === false) {
    /**
     * 주어진 타입의 AbstractUIObject 인스턴스를 생성하여 반환한다.
     *
     * @package Xpressengine\UIObject
     *
     * @param string $id   UIObject의 id, 또는 alias
     * @param mixed  $args UIObject를 생성할 때 전달할 argument
     *
     * @return \Xpressengine\UIObject\AbstractUIObject 생성된 AbstractUIObject
     * @throws Exception
     */
    function uio($id, $args = [])
    {
        try {
            return XeUI::create($id, $args)->render();
        } catch (\Xpressengine\UIObject\Exceptions\UIObjectNotFoundException $e) {
            if (config('app.debug') === true) {
                return "UI오브젝트[$id]를 찾을 수 없습니다";
            } else {
                return '';
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

if (!function_exists('instance_route')) {
    /**
     * Generate a URL to a named route.
     *
     * @package Xpressengine\Routing
     *
     * @param  string                   $name       route name
     * @param  array                    $parameters route parameter
     * @param  string                   $instanceId instance id
     * @param  bool                     $absolute   absolute bool
     * @param  Illuminate\Routing\Route $route      illuminate route
     *
     * @return string
     */
    function instance_route($name, $parameters = array(), $instanceId = null, $absolute = true, $route = null)
    {
        if ($instanceId === null) {
            $instanceConfig = Xpressengine\Routing\InstanceConfig::instance();
            $module = $instanceConfig->getModule();
            $url = $instanceConfig->getUrl();
        } else {
            /**
             * @var Xpressengine\Routing\RouteRepository $instanceRouter
             */
            $instanceRouter = app('xe.router');
            $instanceRoute = $instanceRouter->findByInstanceId($instanceId);
            $url = $instanceRoute->url;
            $module = $instanceRoute->module;
        }

        $name = $module.'.'.$name;

        array_unshift($parameters, $url);

        return app('url')->route($name, $parameters, $absolute, $route);
    }
}

if (!function_exists('expose_route')) {
    /**
     * front-end에서 사용할 수 있도록 지정한 Route 정보를 노출
     *
     * @package Xpressengine\Routing
     *
     * @param string $routeName Route name
     * @param array  $params    route parameter
     * @return void
     */
    function expose_route($routeName, $params = [])
    {
        $route = app('router')->getRoutes()->getByName($routeName);

        if (in_array('settings', $route->middleware()) &&
            !in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER])
        ) {
            return;
        }

        XeFrontend::route($routeName, array(
            'uri' => $route->uri(),
            'methods' => $route->methods(),
            'params' => $params
        ));
    }
}

if (!function_exists('expose_instance_route')) {
    /**
     * front-end에서 사용할 수 있도록 지정한 instance 포함한 Route 정보를 노출
     *
     * @package Xpressengine\Routing
     *
     * @param string $routeName  Route name
     * @param array  $params     route parameter
     * @param string $instanceId instance ID
     * @return void
     */
    function expose_instance_route($routeName, $params = [], $instanceId = null)
    {
        if ($instanceId === null) {
            $instanceConfig = Xpressengine\Routing\InstanceConfig::instance();
            $url = $instanceConfig->getUrl();
            $module = $instanceConfig->getModule();
            $instanceId = $instanceConfig->getInstanceId();
        } else {
            /**
             * @var Xpressengine\Routing\RouteRepository $instanceRouter
             */
            $instanceRouter = app('xe.router');
            $instanceRoute = $instanceRouter->findByInstanceId($instanceId);
            $url = $instanceRoute->url;
            $module = $instanceRoute->module;
        }

        $routeName = $module . '.' . $routeName;

        $route = app('router')->getRoutes()->getByName($routeName);
        if (in_array('settings', $route->middleware()) &&
            !in_array(Auth::user()->getRating(), [\Xpressengine\User\Rating::SUPER, \Xpressengine\User\Rating::MANAGER])
        ) {
            return;
        }

        $uri = $route->uri();

        if (starts_with($route->getPrefix(), '{instanceGroup')) {
            $uri = str_replace_first($route->getPrefix(), '{url}', $uri);
        }

        $parameters['url'] = $url;
        $parameters['instanceId'] = $instanceId;

        XeFrontend::route($routeName, array(
            'uri' => $uri,
            'methods' => $route->methods(),
            'params' => $parameters
        ));
    }
}

if (!function_exists('expose_trans')) {
    /**
     * front-end에서 사용할 수 있도록 지정한 Translation 정보를 노출
     *
     * @param string $keys trans ID
     * @return void
     */
    function expose_trans($keys)
    {
        XeFrontend::translation($keys);
    }
}

if (!function_exists('current_instance_id')) {
    /**
     * Return current Instance Id
     *
     * @package Xpressengine\Menu
     *
     * @return string
     */
    function current_instance_id()
    {
        $instanceConfig = Xpressengine\Routing\InstanceConfig::instance();
        return $instanceConfig->getInstanceId();
    }
}

if (!function_exists('current_selected_instance_ids')) {
    /**
     * Return current selected Instance Ids
     *
     * @package Xpressengine\Menu
     *
     * @return string
     */
    function current_selected_instance_ids()
    {
        $instanceConfig = Xpressengine\Routing\InstanceConfig::instance();
        return $instanceConfig->getSelectedInstanceIds();
    }
}

if (!function_exists('current_menu')) {

    /**
     * Returns current menu item
     *
     * @package Xpressengine\Menu
     * @return Xpressengine\Menu\Models\MenuItem|null
     */
    function current_menu()
    {
        $instanceConfig = Xpressengine\Routing\InstanceConfig::instance();
        return $instanceConfig->getMenuItem();
    }
}

if (!function_exists('menu_list')) {

    /**
     * 메뉴를 html 마크업으로 출력할 때, 사용하기 쉽도록 메뉴아이템 리스트를 제공한다.
     *
     * @package Xpressengine\Menu
     *
     * @param string               $menuId   출력할 메뉴의 ID
     * @param string|callable|null $selected 선택된 아이템 지정
     *
     * @return Illuminate\Support\Collection 메뉴아이템 리스트
     */
    function menu_list($menuId, $selected = null)
    {
        $menu = null;
        if ($menuId !== null) {
            $menu = XeMenu::menus()->findWith(
                $menuId,
                [
                    'items.basicImage',
                    'items.hoverImage',
                    'items.selectedImage',
                    'items.mBasicImage',
                    'items.mHoverImage',
                    'items.mSelectedImage'
                ]
            );
        }

        /** @var Xpressengine\Menu\Models\Menu $menu */
        if ($menu !== null) {
            if (!function_exists('removeInvisible')) {

                /**
                 * 보이지 않는(보기 권한이 없는) 메뉴는 제외시킨다.
                 *
                 * @param \Xpressengine\Menu\Models\MenuItem $item menu item
                 * @param \Xpressengine\Menu\Models\Menu     $menu menu
                 *
                 * @return null|\Xpressengine\Menu\Models\MenuItem
                 */
                function removeInvisible($item, $menu)
                {

                    // resolve item
                    if (Gate::denies('visible', [$item, $menu])) {
                        return null;
                    }

                    // resolve child menuitems of item
                    $children = new \Illuminate\Support\Collection();
                    foreach ($item->getChildren() as $child) {
                        if ($new = removeInvisible($child, $menu)) {
                            if ($new) {
                                $children[] = $new;
                            }
                        }
                    }
                    $item->setChildren($children);

                    return $item;
                }
            }

            $current = $selected ?: current_selected_instance_ids();

            if ($current !== null) {
                $current = is_array($current) === true ? $current : [$current];

                foreach ($current as $value) {
                    $menu->setItemSelected($value);
                }
            }

            $tree = $menu->getTree()->getTreeNodes();
            $loaded = \Illuminate\Database\Eloquent\Collection::make($tree)->load('ancestors');

            $tree->transform(function ($menuItem, $key) use($loaded) {
                return $loaded->find($loaded[$key]);
            });

            // resolve menu visible
            $menuTree = [];
            foreach ($tree as $item) {
                if ($new = removeInvisible($item, $menu)) {
                    $menuTree[] = $new;
                }
            }

            return $menuTree;
        } else {
            return new Illuminate\Support\Collection();
        }
    }
}

if (!function_exists('short_module_id')) {
    /**
     * Generate a short Menu Type Id
     *
     * @package Xpressengine\Module
     *
     * @param  string $moduleId extract 'module/'
     *
     * @return string
     */
    function short_module_id($moduleId)
    {
        return str_ireplace('module/', '', $moduleId);
    }
}

if (!function_exists('full_module_id')) {
    /**
     * Get a full Module Id
     *
     * @package Xpressengine\Module
     *
     * @param  string $moduleId to prepend 'module/'
     *
     * @return string
     */
    function full_module_id($moduleId)
    {
        if (stripos($moduleId, 'module/') !== false) {
            return $moduleId;
        } else {
            return 'module/'.$moduleId;
        }
    }
}

if (!function_exists('module_class')) {
    /**
     * Get a Module Id class name
     *
     * @package Xpressengine\Module
     *
     * @param  string $moduleId to find menu type class
     *
     * @return string|null
     */
    function module_class($moduleId)
    {
        return XeMenu::getModuleHandler()->getModuleClassName(full_module_id($moduleId));
    }
}

if (function_exists('widget') === false) {
    /**
     * widget
     *
     * @package Xpressengine\Widget
     *
     * @param string  $id       widget id
     * @param array   $args     to render html arguments
     * @param closure $callback if it need
     *
     * @return mixed
     */
    function widget($id, $args = [], $callback = null)
    {
        return new \Illuminate\Support\HtmlString(app('xe.widget')->render($id, $args, $callback));
    }
}

if (function_exists('df') === false) {
    /**
     * @package Xpressengine\DynamicField
     *
     * @param string $group      group name
     * @param string $columnName dynamic field id
     *
     * @return \Xpressengine\DynamicField\AbstractType
     */
    function df($group, $columnName)
    {
        return \XeDynamicField::get($group, $columnName);
    }
}

if (function_exists('df_create') === false) {
    /**
     * @package Xpressengine\DynamicField
     *
     * @param string $group      group name
     * @param string $columnName dynamic field id
     * @param array  $args       arguments
     *
     * @return string
     */
    function df_create($group, $columnName, $args)
    {
        $fieldType = df($group, $columnName);
        if ($fieldType == null) {
            return '';
        }
        return $fieldType->getSkin()->create($args);
    }
}

if (function_exists('df_edit') === false) {
    /**
     * @package Xpressengine\DynamicField
     *
     * @param string $group      group name
     * @param string $columnName dynamic field id
     * @param array  $args       arguments
     *
     * @return string
     */
    function df_edit($group, $columnName, $args)
    {
        $fieldType = df($group, $columnName);
        if ($fieldType == null) {
            return '';
        }
        return $fieldType->getSkin()->edit($args);
    }
}

if (function_exists('plugins_path') === false) {
    /**
     * @package Xpressengine\Plugin
     *
     * @param string $path path
     *
     * @return string
     */
    function plugins_path($path = '')
    {
        $path = trim($path, DIRECTORY_SEPARATOR);
        return app('path.plugins').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (! function_exists('app_storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param  string $path sub path
     *
     * @return string
     */
    function app_storage_path($path = '')
    {
        $path = trim($path, DIRECTORY_SEPARATOR);
        return storage_path('app').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('editor')) {
    /**
     * @package Xpressengine\Editor
     *
     * @param string      $instanceId instance id
     * @param array|false $arguments  argument for editor
     * @param string|null $targetId   target id
     * @param string|null $coverId    cover id
     *
     * @return string
     */
    function editor($instanceId, $arguments, $targetId = null, $coverId = null)
    {
        return app('xe.editor')->render($instanceId, $arguments, $targetId, $coverId);
    }
}

if (!function_exists('compile')) {
    /**
     * @package Xpressengine\Editor
     *
     * @param string $instanceId instance id
     * @param string $content    content
     * @param bool   $htmlable   content is htmlable
     *
     * @return string
     */
    function compile($instanceId, $content, $htmlable = false)
    {
        return app('xe.editor')->compile($instanceId, $content, $htmlable);
    }
}

if (!function_exists('purify')) {
    /**
     * @package Xpressengine\Editor
     *
     * @param string $content content
     * @return \Xpressengine\Support\Purifier|string
     */
    function purify($content = null)
    {
        $purifier = new \Xpressengine\Support\Purifier();
        if (!$content) {
            return $purifier;
        }

        return $purifier->purify($content);
    }

}

if (!function_exists('xe_error')) {
    /**
     * @param string $message    error message
     * @param int    $statusCode error status code
     * @return void
     * @throws \Xpressengine\Support\Exceptions\XpressengineException
     */
    function xe_error($message = null, $statusCode = 500)
    {
        $exception = new \Xpressengine\Support\Exceptions\HttpXpressengineException(
            [], $statusCode
        );
        $exception->setMessage($message);
        throw $exception;
    }
}

if (!function_exists('config_file_generate')) {
    /**
     * Generate a config file.
     *
     * @param string $key  key name
     * @param array  $data data
     * @return void
     */
    function config_file_generate($key, array $data)
    {
        $dir = config_path() . '/' . env('APP_ENV', 'production');
        $filesystem = app('files');
        if (!$filesystem->isDirectory($dir)) {
            return $filesystem->makeDirectory($dir);
        }

        $data = encode_arr2str($data);

        $file = $dir . "/{$key}.php";
        file_put_contents($file, '<?php' . str_repeat(PHP_EOL, 2) . 'return [' . PHP_EOL . $data . '];' . PHP_EOL);
    }
}

if (!function_exists('encode_arr2str')) {
    /**
     * Encode array to string.
     *
     * @param array $arr   array
     * @param int   $depth depth
     * @return string
     */
    function encode_arr2str(array $arr, $depth = 0)
    {
        $output = '';

        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $output .= str_indent($depth) . "'{$key}' => " . '[' . PHP_EOL . encode_arr2str($val, $depth + 1) . str_indent($depth) . '],' . PHP_EOL;
            } else {
                if (is_bool($val)) {
                    $val = $val ? 'true' : 'false';
                } elseif (!is_int($val)) {
                    $val = "'{$val}'";
                }
                $output .= str_indent($depth) . "'{$key}' => " . $val .',' . PHP_EOL;
            }
        }

        return $output;
    }
}

if (!function_exists('unescape')) {
    /**
     * @param $str
     * @return string
     */
    function unescape($str) {
        $ret = '';
        $len = strlen ( $str );
        for($i = 0; $i < $len; $i ++) {
            if ($str [$i] == '%' && $str [$i + 1] == 'u') {
                $val = hexdec ( substr ( $str, $i + 2, 4 ) );
                if ($val < 0x7f)
                    $ret .= chr ( $val );
                else if ($val < 0x800)
                    $ret .= chr ( 0xc0 | ($val >> 6) ) . chr ( 0x80 | ($val & 0x3f) );
                else
                    $ret .= chr ( 0xe0 | ($val >> 12) ) . chr ( 0x80 | (($val >> 6) & 0x3f) ) . chr ( 0x80 | ($val & 0x3f) );
                $i += 5;
            } else if ($str [$i] == '%') {
                $ret .= urldecode ( substr ( $str, $i, 3 ) );
                $i += 2;
            } else
                $ret .= $str [$i];
        }
        return $ret;
    }
}

if (!function_exists('str_indent')) {
    /**
     * Get indent.
     *
     * @param int $depth depth
     * @return string
     */
    function str_indent($depth, $len = 4)
    {
        $indent = '';
        for ($a = 0; $a <= $depth; $a++) {
            $indent .= str_repeat(' ', $len);
        }

        return $indent;
    }
}

if (!function_exists('array_depth')) {
    /**
     * get array's depth
     *
     * @param array $array
     * @return int
     */
    function array_depth(array $array) {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }
}


if (function_exists('email_masking') === false) {
    /**
     * 이메일 마스킹 처리
     *
     * @param $email
     * @param int $offset
     * @return bool|string
     */
    function email_masking($email, $offset = 2)
    {
        $parts = explode('@', $email);
        if (count($parts) < 2) {
            return str_masking($email, $offset);
        }

        list($id, $host) = $parts;
        $email = sprintf('%s@%s', str_masking($id, $offset), $host);
        return $email;
    }
}

if (function_exists('str_masking') === false) {
    /**
     * 문자열 마스킹 처리
     *
     * @param $str
     * @param int $offset
     * @return bool|string
     */
    function str_masking($str, $offset = 2)
    {
        $len = strlen($str);
        $start = $offset;

        /*
         * 대상 문자가 너무 짧을 경우 마스킹을 하나 더 길게
         * ex ) abcd => ab**
         * ex ) abc => a**
         */
        if ($len <= $offset + 1) {
            $start = $offset - 1;
        }

        $str = substr($str, 0, $start);
        for ($i = $start; $i < $len; $i++) {
            $str .= '*';
        }

        return $str;
    }
}

if (function_exists('phone_masking') === false) {
    /**
     * 전화번호 마스킹 처리
     *
     * @param $phone
     * @param int $offset
     * @return bool|string
     */
    function phone_masking($phone, $offset = 4)
    {
        $phone = str_replace('-', '', $phone);

        $arrNetId = [
            '010', '011', '012', '013', '014', '015', '016', '017', '018', '019',
            '030', '050', '060', '070', '080',
            '020', '040', '090',
            '02','031','032','033','041','043','042','044','051','052','053','054','055','061','062','063','064',
        ];

        // 끝에 4개 마스킹
        $len = strlen($phone);
        $start = $offset;

        // 통신망 식별변호 분리
        $strPos = false;
        foreach ($arrNetId as $netId) {
            $strPos = strpos($phone, $netId);
            if ($strPos !== false && $strPos === 0) {
//                dump($strPos, $netId, $phone);
                break;
            }
        }

        if ($strPos !== false && $netId) {
            $a = $len - strlen($netId) - 4;
            $masking = '';
            for($i=0; $i<$a; $i++) {
                $masking .= '*';
            }

//            $str = $netId . '-' . $masking . '-' . substr($phone, -4) . '('.$phone.')';
            $str = $netId . '-' . $masking . '-' . substr($phone, -4);
        } else {
            /*
             * 대상 문자가 너무 짧을 경우 마스킹을 하나 더 길게
             * ex ) abcd => ab**
             * ex ) abc => a**
             */
            if ($len <= $offset + 1) {
                $start = $offset - 1;
            }

            $str = substr($phone, 0, -$start);
            for ($i = 0; $i < $start; $i++) {
                $str .= '*';
            }
        }

        return $str;
    }
}

if (function_exists('is_home') === false) {
    /**
     * 현재 라우트가 홈인지 확인합니다.
     *
     * @return bool
     */
    function is_home() {
        return app('xe.site')->getHomeInstanceId() === current_instance_id();
    }
}

if (function_exists('is_settings') === false) {
    /**
     * 현재 관리자 세팅 (settings) 페이지인지 확인합니다.
     *
     * @return bool
     */
    function is_settings() {
        $currentRoute = request()->route();

        if (($currentRoute instanceof \Illuminate\Routing\Route) === false) {
            return null;
        }

        $middlewares = $currentRoute->getAction('middleware') ?? [];

        return in_array('settings', $middlewares, true) === true;
    }
}

if (!function_exists('put_translator_lang_data')) {
    /**
     * Put translator lang data
     *
     * @param string $namespace
     * @param array $langTexts
     * @return string
     */
    function put_translator_lang_data(string $namespace, array $langTexts)
    {
        $keyGen = app(\Xpressengine\Keygen\Keygen::class);
        $translator = app(\Xpressengine\Translation\Translator::class);

        $newId = $keyGen->generate();

        $langData = new \Xpressengine\Translation\LangData();
        $locales = collect(XeLang::getLocales());

        foreach ($locales as $locale) {
            if (filled($text = array_get($langTexts, $locale))) {
                $langData->setLine($newId, $locale, $text);
            }
        }

        $translator->putLangData($namespace, $langData);
        return $namespace . '::' . $newId;
    }
}
