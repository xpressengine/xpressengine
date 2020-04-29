<?php
/**
 * Operator.php
 *
 * PHP version 7
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Foundation;

use Carbon\Carbon;
use Xpressengine\Foundation\Operations\CoreOperation;
use Xpressengine\Foundation\Operations\Operation;
use Xpressengine\Foundation\Operations\PluginOperation;
use Xpressengine\Foundation\Operations\PrivateOperation;

/**
 * Class Operator
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Operator
{
    /**
     * The path of data file
     *
     * @var string
     */
    protected $path;

    /**
     * The operation raw data
     *
     * @var array
     */
    protected $data;

    /**
     * The operations
     *
     * @var array
     */
    protected $operations;

    const TYPE_CORE = 'core';
    const TYPE_PLUGIN = 'plugin';
    const TYPE_PRIVATE = 'private';

    /**
     * Operator constructor.
     *
     * @param string $path the path of data file
     */
    public function __construct($path)
    {
        $this->path = $path;

        $this->load();
    }

    /**
     * Load the raw data
     *
     * @return void
     */
    public function load()
    {
        $this->data = [];
        if (file_exists($this->path)) {
            $this->data = json_decode(file_get_contents($this->path), true);
        }

        $this->operations = [];
    }

    /**
     * Set a operation for the core.
     *
     * @param bool $run set status to running
     * @return $this
     */
    public function setCoreMode($run = true)
    {
        $this->data['type'] = static::TYPE_CORE;

        $operation = $this->getOperation($this->data['type']);

        $this->defaultSetUp($operation, $run);

        return $this;
    }

    /**
     * Set a operation for the plugin.
     *
     * @param bool $run set status to running
     * @return $this
     */
    public function setPluginMode($run = true)
    {
        $this->data['type'] = static::TYPE_PLUGIN;

        $operation = $this->getOperation($this->data['type']);
        $operation->flush();

        $this->defaultSetUp($operation, $run);

        return $this;
    }

    /**
     * Set a operation for the private plugin.
     *
     * @param bool $run set status to running
     * @return $this
     */
    public function setPrivateMode($run = true)
    {
        $this->data['type'] = static::TYPE_PRIVATE;

        $operation = $this->getOperation($this->data['type']);
        $operation->flush();

        $this->defaultSetUp($operation, $run);

        return $this;
    }

    /**
     * Set default operation information.
     *
     * @param Operation $operation the operation
     * @param bool      $run       set status to running
     * @return void
     */
    protected function defaultSetUp(Operation $operation, $run = true)
    {
        $run ? $operation->running() : $operation->ready();

        $operation->expiresAt(null);
        $operation->completedAt(null);
    }

    /**
     * Lock the operation.
     *
     * @param bool $throw throw exception if given value is true
     * @return void
     * @throws \Exception
     */
    public function lock($throw = true)
    {
        if ($this->isLocked() && $throw) {
            throw new \Exception('The operation is locked. Make sure that another process is running.');
        }

        $this->data['lock'] = true;
        $this->write();
    }

    /**
     * Unlock the operation.
     *
     * @return void
     * @throws \Exception
     */
    public function unlock()
    {
        $this->data['lock'] = false;
        $operation = $this->getOperation();
        $operation->completedAt(Carbon::now()->toDateTimeString());
        if ($operation->isInProgress()) {
            // 종료시점까지 결과값이 정의 되지 않으면 실패로 처리
            $operation->failed();
        }
        $this->write();
    }

    /**
     * Determine if the operation is locked.
     *
     * @return bool|mixed
     */
    public function isLocked()
    {
        return $this->data['lock'] ?? false === true;
    }

    /**
     * Write current data to the file.
     *
     * @return void
     */
    public function write()
    {
        if ($operation = $this->getOperation($type = $this->getType())) {
            $this->data['operations'][$type] = $operation->toArray();
        }
        $json = json_encode($this->data);
        if (function_exists('json_format')) {
            $json = json_format($json);
        } else {
            $json = \Composer\Json\JsonFormatter::format($json, true, true);
        }
        file_put_contents($this->path, $json);
    }

    /**
     * Save current data
     *
     * @return void
     */
    public function save()
    {
        $this->write();
    }

    /**
     * Get current operation type.
     *
     * @return mixed|null
     */
    public function getType()
    {
        return $this->data['type'] ?? null;
    }

    /**
     * Get the operation.
     *
     * @param string|null $type operation type
     * @return Operation|null
     */
    public function getOperation($type = null)
    {
        $type = $type ?: $this->getType();

        if (!isset($this->operations[$type])) {
            $this->operations[$type] = $this->createOperation($type);
        }

        return $this->operations[$type];
    }

    /**
     * Create a new operation instance.
     *
     * @param string $type the operation type
     * @return Operation|null
     */
    protected function createOperation($type)
    {
        $data = $this->data['operations'][$type] ?? [];
        switch ($type) {
            case static::TYPE_CORE:
                return $this->createCoreOperation($data);
                break;
            case static::TYPE_PLUGIN:
                return $this->createPluginOperation($data);
                break;
            case static::TYPE_PRIVATE:
                return $this->createPrivateOperation($data);
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Create a core operation.
     *
     * @param array $data raw data
     * @return CoreOperation
     */
    protected function createCoreOperation(array $data)
    {
        return new CoreOperation($data);
    }

    /**
     * Create a plugin operation.
     *
     * @param array $data $data raw data
     * @return PluginOperation
     */
    protected function createPluginOperation(array $data)
    {
        return new PluginOperation($data);
    }

    /**
     * Create a private plugin operation.
     *
     * @param array $data $data raw data
     * @return PrivateOperation
     */
    protected function createPrivateOperation(array $data)
    {
        return new PrivateOperation($data);
    }

    /**
     * Determine if the current operation type is core.
     *
     * @return bool
     */
    public function isCore()
    {
        return $this->getType() === static::TYPE_CORE;
    }

    /**
     * Determine if the current operation type is plugin.
     *
     * @return bool
     */
    public function isPlugin()
    {
        return $this->getType() === static::TYPE_PLUGIN;
    }

    /**
     * Determine if the current operation type is private.
     *
     * @return bool
     */
    public function isPrivate()
    {
        return $this->getType() === static::TYPE_PRIVATE;
    }

    /**
     * Dynamically call the current operation instance.
     *
     * @param string $name      method
     * @param array  $arguments arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (!$type = $this->getType()) {
            return null;
        }
        return call_user_func_array([$this->getOperation($type), $name], $arguments);
    }
}
