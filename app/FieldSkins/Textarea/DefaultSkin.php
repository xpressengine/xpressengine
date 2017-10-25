<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\Textarea;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractSkin;
use View;

class DefaultSkin extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Textarea/fieldSkin/xpressengine@TextareaDefault';
    protected $name = 'Textarea default';
    protected $description = 'Textarea 디폴트 스킨';


    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Textarea default';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/textarea/default';
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
}