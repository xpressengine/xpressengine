<?php
/**
 * WidgetBoxHandler
 *
 * PHP version 5
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Widget;

use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\User\Rating;
use Xpressengine\Widget\Exceptions\IDAlreadyExistsException;
use Xpressengine\Widget\Exceptions\IDNotFoundException;
use Xpressengine\Widget\Exceptions\InvalidIDException;
use Xpressengine\Widget\Models\WidgetBox;

/**
 * WidgetBoxHandler
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
     * @return void
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

        $options = array_get($data, 'options', []);
        if (is_array($options)) {
            $options = json_encode($options);
        }

        $title = array_get($data, 'title', $id);

        $content = array_get($data, 'content', '');

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
