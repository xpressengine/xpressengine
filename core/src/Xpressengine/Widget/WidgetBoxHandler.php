<?php
/**
 * WidgetBoxHandler
 *
 * PHP version 7
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Widget;

use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Register\Container;
use Xpressengine\User\Rating;
use Xpressengine\Widget\Exceptions\IDAlreadyExistsException;
use Xpressengine\Widget\Exceptions\IDNotFoundException;
use Xpressengine\Widget\Exceptions\InvalidIDException;
use Xpressengine\Widget\Models\WidgetBox;
use Xpressengine\Widget\Presenters\XEUIPresenter;

/**
 * WidgetBoxHandler
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetBoxHandler
{
    /**
     * @var WidgetBoxRepository
     */
    private $repository;

    /**
     * @var PermissionHandler
     */
    private $permissionHandler;

    /**
     * @var Container
     */
    protected static $container;

    /**
     * @var string
     */
    const REGISTER_KEY = 'widget/presenter';

    /**
     * WidgetBoxHandler constructor.
     *
     * @param WidgetBoxRepository $repository        widgetbox repository
     * @param PermissionHandler   $permissionHandler permission handler
     */
    public function __construct(WidgetBoxRepository $repository, PermissionHandler $permissionHandler)
    {
        $this->repository = $repository;
        $this->permissionHandler = $permissionHandler;
    }

    /**
     * 위젯박스를 생성한다.
     *
     * @param array $data 생성할 위젯박스의 데이터
     *
     * @return WidgetBox
     */
    public function create($data)
    {
        $id = array_get($data, 'id');

        if ($id === null) {
            throw new IDNotFoundException();
        }

        if (str_contains($id, '.')) {
            throw new InvalidIDException();
        }

        if ($this->repository->find($id) !== null) {
            throw new IDAlreadyExistsException();
        }

        $options = array_get($data, 'options', ['presenter' => XEUIPresenter::class]);
        $title = array_get($data, 'title', $id);
        $content = array_get($data, 'content');
        $content = empty($content) ? [] : $content;

        $widgetbox = $this->repository->create(compact('id', 'title', 'content', 'options'));

        $grant = new Grant();
        $grant->set(
            'edit',
            [
                Grant::RATING_TYPE => Rating::SUPER,
                Grant::GROUP_TYPE => [],
                Grant::USER_TYPE => [],
                Grant::EXCEPT_TYPE => []
            ]
        );

        $this->permissionHandler->register('widgetbox.'.$id, $grant);

        return $widgetbox;
    }

    /**
     * 위젯박스 정보를 업데이트 한다.
     *
     * @param WidgetBox|string $widgetbox     Widgetbox 인스턴스나 위젯박스 아이디
     * @param array            $widgetboxData 업데이트 정보
     *
     * @return WidgetBox
     */
    public function update($widgetbox, $widgetboxData = [])
    {
        if ($widgetbox instanceof WidgetBox === false) {
            $widgetbox = $this->repository->find($widgetbox);
        }

        return $this->repository->update($widgetbox, $widgetboxData);
    }

    /**
     * 위젯박스를 삭제한다.
     *
     * @param WidgetBox|string $widgetbox 삭제할 위젯박스
     *
     * @return void
     */
    public function delete($widgetbox)
    {
        if (is_string($widgetbox)) {
            $widgetbox = $this->repository->find($widgetbox);
        }
        $this->permissionHandler->destroy('widgetbox.'.$widgetbox->id);
        $widgetbox->delete();
    }

    /**
     * Add presenter class to container
     *
     * @param string $presenter presenter class name
     * @return void
     */
    public static function addPresenter($presenter)
    {
        static::$container->push(static::REGISTER_KEY, $presenter);
    }

    /**
     * Get presenter class list
     *
     * @return array
     */
    public static function getPresenters()
    {
        return static::$container->get(static::REGISTER_KEY, []);
    }

    /**
     * Set container instance
     *
     * @param Container $container container instance
     * @return void
     */
    public static function setContainer(Container $container)
    {
        static::$container = $container;
    }

    /**
     * 기본적으로 WidgetBoxHandler는 WidgetBoxRepository의 프록시 역할을 한다.
     *
     * @param string $name      method name
     * @param array  $arguments arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repository, $name], $arguments);
    }
}
