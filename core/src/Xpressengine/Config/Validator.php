<?php
/**
 * Validator
 *
 * PHP version 5
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config;

use Illuminate\Validation\Factory as ValidationFactory;

/**
 * config 가 유효한지 확인하는 역할을 수행 함
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Validator
{
    /**
     * minimum name length
     *
     * @var int
     */
    private $minNameLength = 3;

    /**
     * maximum name length
     *
     * @var int
     */
    private $maxNameLength = 255;

    /**
     * validation factory instance
     *
     * @var ValidationFactory
     */
    protected $factory;

    /**
     * custom target list array
     *
     * @var array
     */
    protected $customTargets = [];

    /**
     * custom rule list array
     *
     * @var array
     */
    protected $customRules = [];

    /**
     * custom message list array
     *
     * @var array
     */
    protected $customMessages = [];

    /**
     * constructor
     *
     * @param ValidationFactory $factory validation factory instance
     */
    public function __construct(ValidationFactory $factory)
    {
        $this->factory = $factory;

        $this->extending();
    }

    /**
     * add new rule to validation factory
     *
     * @return void
     */
    private function extending()
    {
        $this->factory->extend('has_parent', function ($attribute, $value) {
            if ($attribute == 'object' && $value->getDepth() > 1 && $value->getParent() === null) {
                return false;
            }

            return true;
        });
    }

    /**
     * validate a given object
     *
     * @param ConfigEntity $config config object
     * @return \Illuminate\Validation\Validator
     */
    public function validate(ConfigEntity $config)
    {
        $targets = [
            'name' => $config->name,
            'object' => $config
        ];

        foreach ($this->customTargets as $keyword => $target) {
            $targets[$keyword] = $target($config);
        }

        $rules = array_merge($this->getRules(), $this->customRules);
        $messages = array_merge($this->getMessages(), $this->customMessages);

        return $this->factory->make($targets, $rules, $messages);
    }

    /**
     * the rules
     *
     * @return array
     */
    protected function getRules()
    {
        return [
            'name' => 'required|min:' . $this->minNameLength . '|max:' . $this->maxNameLength,
            'object' => 'has_parent'
        ];
    }

    /**
     * validation failure messages
     *
     * @return array
     */
    protected function getMessages()
    {
        return [
            'has_parent' => 'The :attribute must be has parent'
        ];
    }

    /**
     * add validation rule
     *
     * @param string      $keyword  match keyword(ex. name, email ..)
     * @param string      $ruleName rule name(ex. require, min, max ..)
     * @param callable    $target   validate target
     * @param string|null $message  rule failure message
     * @return void
     */
    public function addRule($keyword, $ruleName, \Closure $target, $message = null)
    {
        $this->customRules[$keyword] = $ruleName;
        $this->customTargets[$keyword] = $target;

        if ($message !== null) {
            $this->customMessages[$ruleName] = $message;
        }
    }

    /**
     * validation factory instance
     *
     * @return ValidationFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
