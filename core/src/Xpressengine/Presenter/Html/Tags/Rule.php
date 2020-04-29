<?php
/**
 * Rule
 *
 * PHP version 7
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationRuleParser;

/**
 * Rule
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Rule
{
    use AttributeTrait;
    use MinifyTrait;
    use TargetTrait;
    use EmptyStringTrait;

    /**
     * @var Rule[]
     */
    protected static $ruleList = [];

    /**
     * @var bool
     */
    protected static $loaded = false;

    /**
     * 해당 인스턴스에 포함된 rule 이름
     *
     * @var string
     */
    protected $ruleName;

    /**
     * 해당 인스턴스에 포함된 rule 목록
     *
     * @var array
     */
    protected $rules;

    /**
     * 입력 받은 rule 출력
     *
     * @return string
     */
    public static function output()
    {
        $output = [];

        $list = static::$ruleList;

        foreach ($list as $runeName => $rules) {
            $output[] = [
                'ruleName' => $runeName,
                'rules' => $rules->render()
            ];
        }

        // $output .= '</script>';

        return json_enc($output);
    }

    /**
     * init
     *
     * @return void
     */
    public static function init()
    {
    }

    /**
     * create instance
     *
     * @param string $ruleName rule 이름
     * @param array  $rules    rules
     *
     * @throws \Exception
     */
    public function __construct($ruleName, $rules)
    {
        if ($rules instanceof Collection == true) {
            $rules = $rules->toArray();
        }

        if (isset(self::$ruleList[$ruleName]) === true) {
            $rules = array_merge($rules, self::$ruleList[$ruleName]->getRules());
        }

        $rules = validator([], $rules)->getRules();

        array_walk($rules, function (&$rule, $key) {
            foreach ($rule as &$item) {
                list($method, $parameter) = ValidationRuleParser::parse($item);
                $method = snake_case($method);
                if (count($parameter)) {
                    $parameter = implode(',', $parameter);
                    $item = implode(':', compact('method', 'parameter'));
                } else {
                    $item = $method;
                }
            }
            $rule = implode('|', $rule);
        });

        $this->ruleName = $ruleName;
        $this->rules = $rules;
        self::$ruleList[$ruleName] = $this;

        if (static::$loaded === false) {
            static::$loaded = true;
            new Translation(
                [
                    'xe::validatorRequired',
                    'xe::validatorAlphanum',
                    'xe::validatorMin',
                    'xe::validatorBetween'
                ]
            );
        }
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * renders
     *
     * @return string
     */
    public function render()
    {
        // $rule = sprintf(
        //     "var ruleSet = { ruleName: \"%s\", rules: %s }",
        //     $this->ruleName,
        //     json_enc($this->rules)
        // ).PHP_EOL;

        return $this->rules;
    }

    /**
     * rule 목록
     *
     * @return array
     */
    public static function getRuleList()
    {
        $rules = [];
        foreach (self::$ruleList as $name => $rule) {
            $rules[$name] = $rule->getRules();
        }
        return $rules;
    }
}
