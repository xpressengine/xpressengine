<?php
/**
 * ValidatesRequestsTrait.php
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Trait ValidatesRequestsTrait
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
trait ValidatesRequestsTrait
{
    use ValidatesRequests{
        ValidatesRequests::validate as originValidate;
    }

    /**
     * The namespace for validation
     *
     * @var string
     */
    protected $validateTranslationNamespace = 'xe';

    /**
     * Validate the given request with the given rules.
     *
     * @param  Request  $request          request
     * @param  array    $rules            validation rules
     * @param  array    $messages         messages
     * @param  array    $customAttributes custom attributes
     * @return array
     */
    public function validate(Request $request, array $rules,
                             array $messages = [], array $customAttributes = [])
    {
        $transAttributes = [];
        foreach ($rules as $key => $val) {
            $transAttributes[$key] = xe_trans($this->validateTranslationNamespace. '::' . camel_case($key));
        }
        return $this->originValidate($request, $rules, $messages, array_merge($transAttributes, $customAttributes));
    }

    /**
     * Set the namespace for translation
     *
     * @param string $namespace namespace
     * @return void
     */
    public function setValidateTranslationNamespace($namespace)
    {
        $this->validateTranslationNamespace = $namespace;
    }
}
