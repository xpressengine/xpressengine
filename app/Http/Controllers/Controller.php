<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests {
        ValidatesRequests::validate as originValidate;
    }

    protected $validateTranslationNamespace = 'xe';
    /**
     * Validate the given request with the given rules.
     *
     * @param  Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
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

    public function setValidateTranslationNamespace($namespace)
    {
        $this->validateTranslationNamespace = $namespace;
    }
}
