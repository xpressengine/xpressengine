<?php
/**
 * PasswordHandler.php
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

namespace Xpressengine\User;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * class PasswordHandler
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PasswordValidator
{
    /**
     * Application instance
     *
     * @var Application
     */
    protected $app;

    /**
     * PasswordValidator constructor.
     *
     * @param Application $app Application instance
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Determine if given password passes the rule.
     *
     * @param string      $password password string
     * @param string|null $level    level
     * @return bool
     */
    public function handle($password, $level = null)
    {
        $rule = $this->getRule($level);

        if (is_string($rule)) {
            if (class_exists($rule)) {
                return $this->doClassRule($rule, $password);
            }

            return $this->doRequiresRule($rule, $password);
        }

        return $this->doArrayCallbackRule($rule, $password);
    }

    /**
     * Execute by class
     *
     * @param string $rule     class name
     * @param string $password password string
     * @return bool
     */
    protected function doClassRule($rule, $password)
    {
        return $this->app->make($rule)->handle($password);
    }

    /**
     * Execute by callback in array
     *
     * @param array  $rule     callback and description
     * @param string $password password string
     * @return bool
     */
    protected function doArrayCallbackRule($rule, $password)
    {
        return call_user_func($rule['validate'], $password);
    }

    /**
     * Execute by specific keyword
     *
     * @param string $rule     rule keywords
     * @param string $password password string
     * @return bool
     */
    protected function doRequiresRule($rule, $password)
    {
        $rules = explode('|', $rule);
        $fails = [];
        foreach ($rules as $rule) {
            list($rule, $parameter) = $this->parseRule($rule);

            $method = 'get' . $rule . 'Required';
            if (!method_exists($this, $method)) {
                throw new InvalidArgumentException("Unknown require rule [$rule]");
            }

            if (!$result = $this->$method($parameter)->handle($password)) {
                $fails[$rule] = $parameter;
            }
        }

        return count($fails) < 1;
    }

    /**
     * Parse a string based rule.
     *
     * @param string $rule rule
     * @return array
     */
    protected function parseRule($rule)
    {
        $parameter = null;
        if (strpos($rule, ':') !== false) {
            list($rule, $parameter) = explode(':', $rule, 2);
        }

        return [Str::studly(trim($rule)), $parameter];
    }

    /**
     * Get determiner for minimum length
     *
     * @param int $len length
     * @return mixed
     */
    protected function getMinRequired($len)
    {
        return new class($len) {
            protected $len;

            /**
             * constructor.
             *
             * @param int $len minimum length
             */
            public function __construct($len)
            {
                $this->len = $len;
            }

            /**
             * Handle validate.
             *
             * @param string $password password
             * @return bool
             */
            public function handle($password)
            {
                return strlen($password) >= $this->len;
            }
        };
    }

    /**
     * Get determiner for letters
     *
     * @return mixed
     */
    protected function getAlphaRequired()
    {
        return new class() {
            /**
             * Handle validate.
             *
             * @param string $password password
             * @return bool
             */
            public function handle($password)
            {
                if (!preg_match_all('$\S*(?=\S*[a-zA-Z])\S*$', $password)) {
                    return false;
                }
                return true;
            }
        };
    }

    /**
     * Get determiner for numbers
     *
     * @return mixed
     */
    protected function getNumericRequired()
    {
        return new class() {
            /**
             * Handle validate.
             *
             * @param string $password password
             * @return bool
             */
            public function handle($password)
            {
                if (!preg_match_all('$\S*(?=\S*[\d])\S*$', $password)) {
                    return false;
                }
                return true;
            }
        };
    }

    /**
     * Get determiner for special characters
     *
     * @return mixed
     */
    protected function getSpecialCharRequired()
    {
        return new class() {
            /**
             * Handle validate.
             *
             * @param string $password password
             * @return bool
             */
            public function handle($password)
            {
                if (!preg_match_all('$\S*(?=\S*[\W])\S*$', $password)) {
                    return false;
                }
                return true;
            }
        };
    }

    /**
     * Get message for validate
     *
     * @param string|null $level level
     * @return string
     */
    public function getMessage($level = null)
    {
        $rule = $this->getRule($level);

        if (is_string($rule)) {
            if (class_exists($rule)) {
                return $this->app->make($rule)->getMessage();
            }

            return $this->buildMessage(explode('|', $rule));
        }

        return $this->trans($rule['description']);
    }

    /**
     * Build message for validate
     *
     * @param array $rules require rules
     * @return string
     */
    protected function buildMessage($rules)
    {
        $requires = [];
        $msgMin = '';
        foreach ($rules as $rule) {
            list($rule, $parameter) = $this->parseRule($rule);
            $rule = Str::camel($rule);
            if ($rule === 'min') {
                $msgMin = $this->trans('xe::lenMin', ['len' => $parameter]);
                continue;
            }
            $requires[] = $this->trans('xe::'.$rule);
        }

        if ($msgMin) {
            array_unshift($requires, $msgMin);
        }

        return $this->trans('xe::passwordMustBe', ['requires' => implode(', ', $requires)]);
    }

    /**
     * Get the rule for given level
     *
     * @param string $level level
     * @return string|array
     */
    public function getRule($level)
    {
        return $this->app['xe.config']->getVal('user.register.password_rules');
    }

    /**
     * Get the default level name.
     *
     * @return string
     *
     * @deprecated since 3.0.8 instead use user.register.password_rules config
     */
    public function getDefaultLevel()
    {
        return $this->app['config']['xe.user.password.default'];
    }

    /**
     * Get translated message for given keyword
     *
     * @param string $key   message keyword
     * @param array  $param parameters
     * @return string
     */
    protected function trans($key, $param = [])
    {
        return $this->app['xe.translator']->trans($key, $param);
    }
}
