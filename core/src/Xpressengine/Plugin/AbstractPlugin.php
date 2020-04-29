<?php
/**
 * AbstractPlugin class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

use ReflectionClass;

/**
 * 이 클래스는 Plugin의 추상클래스다. XE3에 플러그인으로 등록되는 모든 클래스는 이 클래스를 상속받아야 한다.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class AbstractPlugin
{

    /**
     * 플러그인 인스턴스를 생성한다
     * 기본적으로 그 디렉토리명을 id로 사용한다.
     */
    public function __construct()
    {
    }

    /**
     * 플러그인의 id를 반환한다.
     *
     * @return string 플러그인 id
     */
    /**
     * @return array|mixed
     */
    public static function getId()
    {
        $ref = new ReflectionClass(static::class);
        $fileName = $ref->getFileName();
        return basename(dirname($fileName));
    }

    /**
     * 플러그인의 id에 주어진 인자를 덧붙여서 반환한다.
     *
     * @param string $postfix   아이디 뒤에 추가할 문자열
     * @param string $delimiter 아이디와 추가할 문자열 사이의 구분자
     *
     * @return string 플러그인 id
     */
    public static function getIdWith($postfix = '', $delimiter = '::')
    {
        return static::getId().($postfix ? $delimiter.$postfix : $postfix);
    }

    /**
     * 플러그인을 활성화한다. 플러그인이 활성화될 때 실행할 코드를 여기에 작성한다.
     *
     * @param string|null $installedVersion 현재 XpressEngine에 설치된 플러그인의 버전정보
     *
     * @return void
     */
    public function activate($installedVersion = null)
    {
    }

    /**
     * 플러그인을 비활성화한다. 플러그인이 비활성화될 때 실행할 코드를 여기에 작성한다
     *
     * @param string|null $installedVersion 현재 XpressEngine에 설치된 플러그인의 버전정보
     *
     * @return void
     */
    public function deactivate($installedVersion = null)
    {
    }

    /**
     * 플러그인을 설치한다. 플러그인이 설치될 때 실행할 코드를 여기에 작성한다
     *
     * @return void
     */
    public function install()
    {
    }

    /**
     * 해당 플러그인이 설치된 상태라면 true, 설치되어있지 않다면 false를 반환한다.
     * 이 메소드를 구현하지 않았다면 기본적으로 XE에 설치된 것으로 간주한다.
     *
     * @return boolean 플러그인의 설치 유무
     */
    public function checkInstalled()
    {
        return true;
    }

    /**
     * 플러그인을 업데이트한다. 플러그인의 소스코드가 XpressEngine에 적용돼 있는 버전보다 최신일 경우 실행된다.
     *
     * @return void
     */
    public function update()
    {
    }

    /**
     * 해당 플러그인이 최신 상태로 업데이트가 된 상태라면 true, 업데이트가 필요한 상태라면 false를 반환함.
     * 이 메소드를 구현하지 않았다면 기본적으로 최신업데이트 상태임(true)을 반환함.
     *
     * @return boolean 플러그인의 설치 유무,
     */
    public function checkUpdated()
    {
        return true;
    }

    /**
     * 플러그인을 설치해제한다. 플러그인 디렉토리가 XpressEngine에서 삭제되기 전에 실행될 코드를 여기에 추가한다.
     *
     * @return void
     */
    public function uninstall()
    {
    }

    /**
     * 이 메소드는 활성화(activate) 된 플러그인이 부트될 때 항상 실행된다.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * 이 메소드는 활성화(activate) 된 플러그인이 부트될 때 항상 실행된다.
     *
     * @return void
     */
    abstract public function boot();

    /**
     * 플러그인의 설정페이지 주소를 반환한다.
     * 플러그인 목록에서 플러그인의 '관리' 버튼을 누를 경우 이 페이지에서 반환하는 주소로 연결된다.
     *
     * @return string
     */
    public function getSettingsURI()
    {
        return null;
    }

    /**
     * 해당 플러그인의 설치 경로를 반환한다.
     * path가 주어질 경우, 주어진 path정보를 추가하여 반환한다.
     *
     * @param string $path path
     *
     * @return string
     */
    public static function path($path = '')
    {
        return plugins_path(static::getId().($path ? DIRECTORY_SEPARATOR.$path : $path));
    }

    /**
     * 해당 플러그인의 asset 파일 주소를 반환한다.
     *
     * @param string $path   path가 주어질 경우 주어진 파일의 URL을 반환한다. path는 해당 플러그인 디렉토리 내에서의 상대 경로이어야 한다.
     * @param string $secure https 여부
     *
     * @return string
     */
    public static function asset($path, $secure = null)
    {
        $path = str_replace(base_path().DIRECTORY_SEPARATOR, '', static::path(trim($path, '/')));

        return asset($path, $secure);
    }

    /**
     * view name을 반환한다. 템플릿 파일 작성시 편의를 위해 사용한다.
     *
     * @param string $view view name
     *
     * @return string
     */
    public static function view($view)
    {
        return static::getId().'::'.$view;
    }
}
