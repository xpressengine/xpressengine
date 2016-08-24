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

use Xpressengine\User\Models\WidgetBox;

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

    public function create($id, $options){
        
    }

    public function update($id, WidgetBox $box){
        
    }

    public function delete($box)
    {

    }
}
