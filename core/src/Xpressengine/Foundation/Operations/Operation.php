<?php
/**
 * Operation.php
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

namespace Xpressengine\Foundation\Operations;

use Carbon\Carbon;

/**
 * Abstract class Operation
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class Operation
{
    const STATUS_READY     = 'ready';
    const STATUS_RUNNING   = 'running';
    const STATUS_SUCCEED   = 'succeed';
    const STATUS_FAILED    = 'failed';
    const STATUS_EXPIRED   = 'expired';

    /**
     * The operation data
     *
     * @var array
     */
    protected $data;

    /**
     * Operation constructor.
     *
     * @param array $data the operation data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Set the operation to ready.
     *
     * @return $this
     */
    public function ready()
    {
        $this->data['status'] = static::STATUS_READY;

        return $this;
    }

    /**
     * Determine if the operation is ready.
     *
     * @return bool
     */
    public function isReady()
    {
        return $this->getStatus() === static::STATUS_READY;
    }

    /**
     * Set the operation to running.
     *
     * @return $this
     */
    public function running()
    {
        $this->data['status'] = static::STATUS_RUNNING;

        return $this;
    }

    /**
     * Determine if the operation is running.
     *
     * @return bool
     */
    public function isRunning()
    {
        return $this->getStatus() === static::STATUS_RUNNING;
    }

    /**
     * Set the operation to succeed.
     *
     * @return $this
     */
    public function succeed()
    {
        $this->data['status'] = static::STATUS_SUCCEED;

        return $this;
    }

    /**
     * Determine if the operation is succeed.
     *
     * @return bool
     */
    public function isSucceed()
    {
        return $this->getStatus() === static::STATUS_SUCCEED;
    }

    /**
     * Set the operation to failed.
     *
     * @return $this
     */
    public function failed()
    {
        $this->data['status'] = static::STATUS_FAILED;

        return $this;
    }

    /**
     * Determine if the operation is failed.
     *
     * @return bool
     */
    public function isFailed()
    {
        return $this->getStatus() === static::STATUS_FAILED;
    }

    /**
     * Set the operation to expired.
     *
     * @return $this
     */
    public function expired()
    {
        $this->data['status'] = static::STATUS_EXPIRED;

        return $this;
    }

    /**
     * Determine if the operation is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->getStatus() === static::STATUS_EXPIRED;
    }

    /**
     * Determine if expires time of the operation is past.
     *
     * @return bool
     */
    public function timeover()
    {
        if (!$expiresAt = $this->data['expires_at'] ?? null) {
            return false;
        }

        return Carbon::parse($expiresAt)->isPast();
    }

    /**
     * Determine if the operation is in progress.
     *
     * @return bool
     */
    public function isInProgress()
    {
        return $this->isReady() || $this->isRunning();
    }

    /**
     * Set the log file path for the operation.
     *
     * @param string $path log file path
     * @return $this
     */
    public function log($path)
    {
        $this->data['log'] = $path;

        return $this;
    }

    /**
     * Get the log file path for the operation.
     *
     * @return string|null
     */
    public function getLogFile()
    {
        return $this->data['log'] ?? null;
    }

    /**
     * Set the expires time for the operation.
     *
     * @param string $datetime expires time (datetime string format)
     * @return $this
     */
    public function expiresAt($datetime)
    {
        $this->data['expires_at'] = $datetime;

        return $this;
    }

    /**
     * Set the completed time for the operation.
     *
     * @param string $datetime completed time (datetime string format)
     * @return $this
     */
    public function completedAt($datetime)
    {
        $this->data['completed_at'] = $datetime;

        return $this;
    }

    /**
     * Get the completed time for the operation.
     *
     * @return string|null
     */
    public function getCompletedAt()
    {
        return $this->data['completed_at'] ?? null;
    }

    /**
     * Get the current status of the operation.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->data['status'] ?? null;
    }

    /**
     * Returns array type data for the operation.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
