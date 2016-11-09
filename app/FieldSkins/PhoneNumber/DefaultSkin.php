<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\PhoneNumber;

use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Config\ConfigEntity;
use View;

class DefaultSkin extends AbstractSkin
{
    protected static $id = 'FieldType/xpressengine@PhoneNumber/FieldSkin/xpressengine@PhoneNumberDefault';

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Phone Number default';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/phoneNumber/default';
    }
}
