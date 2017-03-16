<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Xpressengine\Support\Migration;

class DynamicFieldMigration extends Migration {

    public function installed()
    {
        \DB::table('config')->insert(['name' => 'dynamicField', 'vars' => '{"required":false,"sortable":false,"searchable":false,"use":true,"tableMethod":false}']);
    }

    public function checkUpdated($installedVersion = null)
    {
        if ($this->hasOldRegisterName() === false) {
            return false;
        }

        return true;
    }

    public function update($installedVersion = null)
    {
        if ($this->hasOldRegisterName() === false) {
            $parent = \XeConfig::get('dynamicField');
            $configs = \XeConfig::children($parent);
            foreach ($configs as $config) {
                $str = $config->get('typeId', '');
                if ($str != '') {
                    $str = str_replace(['FieldType', 'FieldSkin'], ['fieldType', 'fieldSkin'], $str);
                    $config->set('typeId', $str);
                }
                $str = $config->get('skinId', '');
                if ($str != '') {
                    $str = str_replace(['FieldType', 'FieldSkin'], ['fieldType', 'fieldSkin'], $str);
                    $config->set('skinId', $str);
                }
                \XeConfig::modify($config);

                $configs2 = \XeConfig::children($config);
                foreach ($configs2 as $config2) {
                    $str = $config2->get('typeId', '');
                    if ($str != '') {
                        $str = str_replace(['FieldType', 'FieldSkin'], ['fieldType', 'fieldSkin'], $str);
                        $config2->set('typeId', $str);
                    }

                    $str = $config2->get('skinId', '');
                    if ($str != '') {
                        $str = str_replace(['FieldType', 'FieldSkin'], ['fieldType', 'fieldSkin'], $str);
                        $config2->set('skinId', $str);
                    }
                    \XeConfig::modify($config2);
                }
            }
            return true;
        }
    }

    /**
     * for version 3.0.0-beta13
     *
     * @return bool
     */
    protected function hasOldRegisterName()
    {
        $parent = \XeConfig::get('dynamicField');
        $configs = \XeConfig::children($parent);
        foreach ($configs as $config) {
            $str = $config->get('typeId', '');
            if ($str != '' && strpos($str, 'FieldType') !== false) {
                return false;
            }
            $str = $config->get('skinId', '');
            if ($str != '' && strpos($str, 'FieldSkin') !== false) {
                return false;
            }

            $configs2 = \XeConfig::children($config);
            foreach ($configs2 as $config2) {
                $str = $config2->get('typeId', '');
                if ($str != '' && strpos($str, 'FieldType') !== false) {
                    return false;
                }
                $str = $config2->get('skinId', '');
                if ($str != '' && strpos($str, 'FieldSkin') !== false) {
                    return false;
                }
            }
        }
        return true;
    }
}
