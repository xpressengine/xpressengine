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

use Illuminate\Support\Collection;
use Xpressengine\DynamicField\AbstractType;

class DynamicFieldParts extends RegisterFormParts
{
    protected static $name = '부가 정보';

    protected static $description = '추가된 확장필드들의 입력 폼입니다.';

    protected static $implicit = true;

    protected static $view = 'register.forms.dfields';

    protected function data()
    {
        $fields = Collection::make($this->getFields())->filter(function ($field) {
            return $field->isEnabled();
        });

        return compact('fields');
    }

    public function rules()
    {
        $rules = Collection::make($this->getFields())->filter(function ($field) {
            return $field->isEnabled();
        })->map(function ($field) {
            return $field->getRules();
        })->collapse();

        return $rules;
    }

    /**
     * @return AbstractType[]
     */
    protected function getFields()
    {
        return $this->getDF()->gets('user');
    }

    protected function getDF()
    {
        return $this->service('xe.dynamicField');
    }
}
