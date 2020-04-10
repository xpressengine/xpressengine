<?php
/**
 * DynamicFieldPart.php
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DynamicFieldPart extends RegisterFormPart
{
    const ID = 'dynamic-fields';

    const NAME = 'xe::customItems';

    const DESCRIPTION = 'xe::descCustomItems';

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
        $useDynamicFields = app('xe.config')->getVal('user.register.dynamic_fields');

        $fields = Collection::make($this->getFields())->filter(function ($field) {
            return $field->isEnabled();
        })->sortBy(function ($field) use ($useDynamicFields) {
            return array_search($field->getConfig()->get('id'), $useDynamicFields);
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
