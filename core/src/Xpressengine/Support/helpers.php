<?php
/**
 * This file is support helper functions
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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

if (! function_exists('xeRedirect')) {
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
    function xeRedirect($to = null, $status = 302, $headers = [], $secure = null, array $data = null)
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

if (function_exists('apiRender') === false) {
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
    function apiRender($id, array $data = [], array $responseData = [])
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
                'XE_ASSET_LOAD' => [
                    'css' => \Xpressengine\Presenter\Html\Tags\CSSFile::getFileList(),
                    'js' => \Xpressengine\Presenter\Html\Tags\JSFile::getFileList(),
                ],
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
     * @param string       $pointCut advice가 실행되기를 바라는 대상 클래스와 메소드, {CLASS명}@{METHOD명}의 형식이어야 한다.
     * @param string|array $name     advisor의 이름 및 우선순위 지정을 위한 array
     * @param Closure      $advice   실행될 Closure
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
     * @param null   $id         다국어 키
     * @param array  $parameters 파라매터
     * @param string $domain     domain
     * @param null   $locale     로케일
     *
     * @return string
     */
    function xe_trans($id = null, $parameters = array(), $domain = 'messages', $locale = null)
    {
        if (is_null($id)) {
            return app('xe.translator');
        }

        try {
            return app('xe.translator')->trans($id, $parameters, $domain, $locale);
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
     * @param string $domain     domain
     * @param null   $locale     로케일
     *
     * @return string
     */
    function xe_trans_choice($id, $number, array $parameters = array(), $domain = 'messages', $locale = null)
    {
        return app('xe.translator')->transChoice($id, $number, $parameters, $domain, $locale);
    }
}

if (function_exists('locale_url') === false) {
    /**
     * locale 변경을 위한 url생성
     *
     * @package Xpressengine\Translation
     *
     * @param string $locale 국가 코드
     * @return string
     */
    function locale_url($locale)
    {
        app('request')->query->set('_l', $locale);

        return app('request')->url() . '?' . http_build_query(app('request')->query->all());
    }
}

if (function_exists('uio') === false) {
    /**
     * 주어진 타입의 AbstractUIObject 인스턴스를 생성하여 반환한다.
     *
     * @package Xpressengine\UIObject
     *
     * @param string $id       UIObject의 id, 또는 alias
     * @param mixed  $args     UIObject를 생성할 때 전달할 argument
     * @param null   $callback UIObject의 출력을 변경하려고 할 때 사용된다. 만약 callback이 지정돼 있으면 UIObject가 출력될 때,
     *                         callback을 한번 실행후 출력한다.
     *                         이 때 callback은 파라메터로 출력될 html의 PhpQueryObject 인스턴스를 전달받는다.
     *                         ```php
     *                         uio('phone', $data, function(PhpQueryObject $markup) {
     *                         $firstNum = $markup['input:first'];
     *                         $firstNum->val('010');
     *                         }
     *                         ```
     *
     * @return \Xpressengine\UIObject\AbstractUIObject 생성된 AbstractUIObject
     * @throws Exception
     */
    function uio($id, $args = [], $callback = null)
    {
        try {
            return XeUI::create($id, $args, $callback)->render();
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

if (!function_exists('instanceRoute')) {
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
    function instanceRoute($name, $parameters = array(), $instanceId = null, $absolute = true, $route = null)
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

if (!function_exists('getCurrentInstanceId')) {
    /**
     * Return current Instance Id
     *
     * @package Xpressengine\Menu
     *
     * @return string
     */
    function getCurrentInstanceId()
    {
        $instanceConfig = Xpressengine\Routing\InstanceConfig::instance();
        return $instanceConfig->getInstanceId();
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
     * @param string $menuId 출력할 메뉴의 ID
     *
     * @return Illuminate\Support\Collection 메뉴아이템 리스트
     */
    function menu_list($menuId)
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
                    foreach ($item['children'] as $child) {
                        if ($new = removeInvisible($child, $menu)) {
                            if ($new) {
                                $children[] = $new;
                            }
                        }
                    }
                    $item['children'] = $children;

                    return $item;
                }
            }

            $current = getCurrentInstanceId();
            if ($current !== null) {
                $menu->setItemSelected($current);
            }
            $tree = $menu->getTree()->getTreeNodes();

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

if (!function_exists('shortModuleId')) {
    /**
     * Generate a short Menu Type Id
     *
     * @package Xpressengine\Module
     *
     * @param  string $moduleId extract 'module/'
     *
     * @return string
     */
    function shortModuleId($moduleId)
    {
        return str_ireplace('module/', '', $moduleId);
    }
}

if (!function_exists('fullModuleId')) {
    /**
     * Get a full Module Id
     *
     * @package Xpressengine\Module
     *
     * @param  string $moduleId to prepend 'module/'
     *
     * @return string
     */
    function fullModuleId($moduleId)
    {
        if (stripos($moduleId, 'module/') !== false) {
            return $moduleId;
        } else {
            return 'module/'.$moduleId;
        }
    }
}

if (!function_exists('moduleClass')) {
    /**
     * Get a Module Id class name
     *
     * @package Xpressengine\Module
     *
     * @param  string $moduleId to find menu type class
     *
     * @return string|null
     */
    function moduleClass($moduleId)
    {
        return XeMenu::getModuleHandler()->getModuleClassName(fullModuleId($moduleId));
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
        return new \Illuminate\View\Expression(app('xe.widget')->render($id, $args, $callback));
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

if (function_exists('dfCreate') === false) {
    /**
     * @package Xpressengine\DynamicField
     *
     * @param string $group      group name
     * @param string $columnName dynamic field id
     * @param array  $args       arguments
     *
     * @return string
     */
    function dfCreate($group, $columnName, $args)
    {
        $fieldType = df($group, $columnName);
        if ($fieldType == null) {
            return '';
        }
        return $fieldType->getSkin()->create($args);
    }
}

if (function_exists('dfEdit') === false) {
    /**
     * @package Xpressengine\DynamicField
     *
     * @param string $group      group name
     * @param string $columnName dynamic field id
     * @param array  $args       arguments
     *
     * @return string
     */
    function dfEdit($group, $columnName, $args)
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
     * @package Xpressengine\Interception
     *
     * @param string $path path
     *
     * @return string
     */
    function plugins_path($path = '')
    {
        $path = trim($path, DIRECTORY_SEPARATOR);
        return rtrim(XePlugin::getPluginsDir(), DIRECTORY_SEPARATOR).($path ? DIRECTORY_SEPARATOR.$path : $path);
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
     *
     * @return string
     */
    function editor($instanceId, $arguments, $targetId = null)
    {
        return app('xe.editor')->render($instanceId, $arguments, $targetId);
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
