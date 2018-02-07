<?php
/**
 * DynamicFieldParts.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Parts;

class DynamicFieldParts extends RegisterFormParts
{
    protected static $name = '부가 정보';

    protected static $description = '추가된 확장필드들의 입력 폼입니다.';

    protected static $implicit = true;

    protected static $view = 'register.forms.dfields';

    protected function data()
    {
        $fields = [];
        foreach ($this->getDF()->gets('user') as $id => $field) {
            if ($field->getConfig()->get('use') == true) {
                $fields[] = $field;
            }
        }

        return compact('fields');
    }

    public function rules()
    {
        $rules = [];
        $configs = $this->getDF()->getConfigHandler()->gets('user');

        foreach ($configs as $config) {
            if ($config->get('use') == true) {
                $rules = array_merge($rules, $this->getDF()->getRules($config));
            }
        }

        return $rules;
    }

    protected function getDF()
    {
        return $this->service('xe.dynamicField');
    }
}
