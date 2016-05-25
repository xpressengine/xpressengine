<?php
/**
 * AbstractPlugin class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Plugin;

/**
 * XE 자료실에 등록된 플러그인들을 조회할 때 사용하는 PluginProvider
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginProvider
{

    /**
     * PluginProvider constructor.
     */
    public function __construct($url)
    {
    }

    public function find($id)
    {

    }

    public function sync(PluginCollection $plugins)
    {
        $ids = array_keys($plugins->getList());
        $infos = $this->findAll($ids);
        foreach ($plugins as $id => $plugin) {
        }
    }

    public function findAll($ids)
    {

    }

    public function search()
    {

    }

    protected function request($url)
    {
    }
}
