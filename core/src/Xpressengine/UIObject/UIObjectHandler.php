<?php
/**
 * UIObjectHandler class.
 *
 * PHP version 7
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\UIObject;

use ReflectionClass;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\UIObject\Exceptions\UIObjectNotFoundException;

/**
 * 이 클래스는 Xpressengine에서 UIObject를 관리하는 클래스이다.
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UIObjectHandler
{
    /**
     * @var PluginRegister
     */
    protected $register;

    /**
     * @var string[] UIObject의 alias를 지정하는 배열. 각각의 UIObject는 `NAMESPACE@KEY` 형식의 id를 갖는데, alias를 등록해놓으면
     *               id 대신 alias로 사용가능하다. 만약 alias에 'select' => 'xpressengine@select'로 등록돼 있다면
     *               `uio('xpressengine@select, [...])` 대신 `uio('select, [...])`로 사용될 수 있다.
     */
    protected $aliases;

    /**
     * 생성자
     *
     * @param PluginRegister $register register
     * @param array          $aliases  uiobject의 id 대신 사용될 alias와 id의 매칭테이블
     */
    public function __construct(PluginRegister $register, $aliases = [])
    {
        $this->register = $register;
        $this->aliases = $aliases;
    }

    /**
     * alias를 등록한다.
     *
     * @param string $alias 지정할 alias
     * @param string $id    주어진 alias에 지정할 UIObject의 id
     *
     * @return void
     */
    public function setAlias($alias, $id)
    {
        $this->aliases[$alias] = $id;
    }

    /**
     * 주어진 id로 등록된 UIObject를 반환한다.
     *
     * @param string $id 반환할 UIObject의 id
     *
     * @return mixed
     */
    public function get($id)
    {
        if (strpos($id, 'uiobject') !== 0) {
            $id = 'uiobject/'.$id;
        }
        return $this->register->get($id);
    }

    /**
     * 등록된 모든 UIObject의 목록을 반환한다.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->register->get('uiobject');
    }

    /**
     * UIObject를 사용할 때, 간결한 인터페이스를 제공하기 위하여 이 메소드가 구현돼 있다.
     * 특정 타입의 UIObject를 생성하기 위하여 아래와 같이 작성할 수 있다.
     *
     * ```
     * // UI는 이 클래스(UIObjectHandler)의 Facade. 메소드에 지정된 타입의 디폴트 UIObject가 생성되어 반환된다.
     * $ui = \XeUI::{alias of uiobject}($args);
     * $ui->render();
     * ```
     *
     * @param string $alias  메소드명은 곧 UIObject의 alias를 지정한다.
     * @param mixed  $params 전달받은 파라메터는 UIObject의 생성시 생성자에 전달될 파라메터
     *
     * @return AbstractUIObject
     */
    public function __call($alias, $params)
    {
        $args = $params[0];

        return $this->create($alias, $args);
    }

    /**
     * 주어진 타입의 AbstractUIObject 인스턴스를 생성하여 반환한다.
     *
     * @param string $id   UIObject의 id, 또는 alias
     * @param mixed  $args UIObject를 생성할 때 전달할 argument
     *
     * @return \Xpressengine\UIObject\AbstractUIObject 생성된 AbstractUIObject
     */
    public function create($id, $args = [])
    {
        // retrieve alias
        if (array_has($this->aliases, $id)) {
            $id = $this->aliases[$id];
        }

        $class = $this->get($id);

        if ($class === null) {
            throw new UIObjectNotFoundException();
        }

        return $this->getInstance($class, [$args]);
    }

    /**
     * 주어진 클래스의 인스턴스를 생성하여 반환한다.
     *
     * @param string $class  생성할 클래스명
     * @param mixed  $params 클래스의 인스턴스를 생성할 때 생성자에 전달할 파라메터
     *
     * @return AbstractUIObject
     */
    protected function getInstance($class, $params)
    {
        $reflection = new ReflectionClass($class);
        return call_user_func_array([$reflection, 'newInstance'], $params);
    }
}
