<?php
/**
 * WidgetBoxHandler
 *
 * PHP version 5
 *
 * @category  WidgetBox
 * @package   Xpressengine\WidgetBox
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\WidgetBox;

use Xpressengine\WidgetBox\Exceptions\InvalidIDException;
use Xpressengine\WidgetBox\Models\WidgetBox;
use Xpressengine\WidgetBox\Exceptions\IDAlreadyExistsException;
use Xpressengine\WidgetBox\Exceptions\IDNotFoundException;

/**
 * @category Widget
 * @package  Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class WidgetBoxHandler
{
    /**
     * @var WidgetBoxRepository
     */
    private $repository;

    /**
     * WidgetBoxHandler constructor.
     *
     * @param WidgetBoxRepository $repository
     */
    public function __construct(WidgetBoxRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($data){

        $id = array_get($data, 'id');

        if($id === null) {
            throw new IDNotFoundException();
        }

        if(str_contains($id, '.')) {
            throw new InvalidIDException();
        }

        if($this->repository->find($id) !== null) {
            throw new IDAlreadyExistsException();
        }

        $options = array_get($data, 'options', []);
        if(is_array($options)) {
            $options = json_encode($options);
        }

        $title = array_get($data, 'title', $id);

        $content = array_get($data, 'content', '');

        $this->repository->create(compact('id', 'title', 'content', 'options'));
    }

    public function update($widgetbox, $widgetboxData = []){
        if($widgetbox instanceof WidgetBox === false) {
            $widgetbox = $this->repository->find($widgetbox);
        }
        return $this->repository->update($widgetbox, $widgetboxData);
    }

    public function delete($widgetbox)
    {

    }

    /**
     * __call
     *
     * @param $name      string
     * @param $arguments array
     *
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return call_user_func_array([$this->repository, $name], $arguments);
    }

}
