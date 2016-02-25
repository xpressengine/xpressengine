<?php
/**
 * DynamicField function.
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
if (function_exists('df') === false) {
    /**
     * @param $group
     * @param $columnName
     * @return \Xpressengine\DynamicField\AbstractType
     */
    function df($group, $columnName)
    {
        return \DynamicField::get($group, $columnName);
    }
}

if (function_exists('dfCreate') === false) {
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
    function dfEdit($group, $columnName, $args)
    {
        $fieldType = df($group, $columnName);
        if ($fieldType == null) {
            return '';
        }
        return $fieldType->getSkin()->edit($args);
    }
}
