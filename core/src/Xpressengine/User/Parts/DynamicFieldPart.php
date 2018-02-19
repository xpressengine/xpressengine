<?php
/**
 * DynamicFieldPart.php
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Parts;

use Illuminate\Support\Collection;
use Xpressengine\DynamicField\AbstractType;

/**
 * Class DynamicFieldPart
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DynamicFieldPart extends RegisterFormPart
{
    const ID = 'dynamic-fields';

    const NAME = '부가 정보';

    const DESCRIPTION = '추가된 확장필드들의 입력 폼입니다.';

    /**
     * Indicates if the form part is implicit
     *
     * @var bool
     */
    protected static $implicit = true;

    /**
     * The view for the form part
     *
     * @var string
     */
    protected static $view = 'register.forms.dfields';

    /**
     * Get data for form part view
     *
     * @return array
     */
    protected function data()
    {
        $fields = Collection::make($this->getFields())->filter(function ($field) {
            return $field->isEnabled();
        });

        return compact('fields');
    }

    /**
     * Get validation rules of the form part
     *
     * @return array
     */
    public function rules()
    {
        $rules = Collection::make($this->getFields())->filter(function ($field) {
            return $field->isEnabled();
        })->map(function ($field) {
            return $field->getRules();
        })->collapse()->all();

        return $rules;
    }

    /**
     * Get dynamic field of the form part
     *
     * @return AbstractType[]|\Generator
     */
    protected function getFields()
    {
        return $this->getDF()->gets('user');
    }

    /**
     * Get dynamic field service
     *
     * @return \Xpressengine\DynamicField\DynamicFieldHandler
     */
    protected function getDF()
    {
        return $this->service('xe.dynamicField');
    }
}
