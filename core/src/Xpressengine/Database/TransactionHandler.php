<?php
/**
 * TransactionHandler
 *
 * PHP version 5
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Database;

use Illuminate\Database\Connection;
use Illuminate\Database\DetectsDeadlocks;
use Illuminate\Database\DetectsLostConnections;
use Exception;
use Throwable;
use Closure;

/**
 * TransactionHandler
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TransactionHandler
{
    use DetectsDeadlocks,
        DetectsLostConnections;

    /**
     * 모든 connector 의 transaction 을 통합해서 관리
     *
     * @var int
     */
    protected $globalTransactions = 0;

    /**
     * singleton instances
     *
     * @var array
     */
    private static $instance;

    /**
     * singleton
     */
    private function __construct()
    {
        // nothing to do
    }

    /**
     * not able clone
     *
     * @return void
     */
    private function __clone()
    {
        // nothing to do
    }

    /**
     * create instance if not exists
     *
     * @return TransactionHandler
     */
    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * destroy singleton instance
     *
     * @return void
     */
    public static function destruct()
    {
        self::$instance = null;
    }

    /**
     * Database 연길 할 때 transaction 이 진행 중이라면 연결하려는 $connection 의 transaction 시작
     * \Illuminiate\Database\Connection 의 transaction level 은 0 또는 1 로 제한.
     * transaction level 은 transaction handler 로 제어.
     *
     * @param Connection $connection connection
     * @return void
     */
    public function setCurrent(Connection $connection)
    {
        if ($this->transactionLevel() > 0 && $connection->transactionLevel() === 0) {
            $connection->beginTransaction();
        }
    }

    /**
     * $connectionHandlers 가 갖고 있는 connection transaction 처리.
     * /Illuminate/Database/Connection 의 transactions 는 1 또는 0.
     * transaction 관리는 globalTransactions 로 처리
     *
     * @param DatabaseCoupler $coupler database coupler
     * @return void
     */
    public function beginTransaction(DatabaseCoupler $coupler)
    {
        ++$this->globalTransactions;
        /** @var VirtualConnection $connector */
        foreach ($coupler->connectors() as $connector) {
            if ($connector->master()->transactionLevel() === 0) {
                $connector->master()->beginTransaction();
            }
        }
    }

    /**
     * $connectionHandlers 가 갖고 있는 connection commit.
     * /Illuminate/Database/Connection 의 commit.
     *
     * @param DatabaseCoupler $coupler database coupler
     * @return void
     */
    public function commit(DatabaseCoupler $coupler)
    {
        if ($this->globalTransactions == 1) {
            /** @var VirtualConnection $connector */
            foreach ($coupler->connectors() as $connector) {
                if ($connector->master()->transactionLevel() >= 1) {
                    $connector->master()->commit();
                }
            }
        }

        --$this->globalTransactions;
    }

    /**
     * $connectionHandlers 가 갖고 있는 connection Rollbsack.
     * /Illuminate/Database/Connection 의 rollBack.
     *
     * @param DatabaseCoupler $coupler database coupler
     * @return void
     */
    public function rollBack(DatabaseCoupler $coupler)
    {
        if ($this->globalTransactions == 1) {
            $this->globalTransactions = 0;

            /** @var VirtualConnection $connector */
            foreach ($coupler->connectors() as $connector) {
                if ($connector->master()->transactionLevel() >= 1) {
                    $connector->master()->rollBack();
                }
            }
        } else {
            --$this->globalTransactions;
        }
    }

    /**
     * Get the number of active transactions.
     *
     * @return int
     */
    public function transactionLevel()
    {
        return $this->globalTransactions;
    }

    /**
     * Execute a Closure within a transaction.
     *
     * @param DatabaseCoupler $coupler  coupler
     * @param \Closure        $callback callback
     * @param int             $attempts attempts
     * @return mixed
     *
     * @throws \Exception|\Throwable
     */
    public function transaction(DatabaseCoupler $coupler, Closure $callback, $attempts = 1)
    {
        for ($currentAttempt = 1; $currentAttempt <= $attempts; $currentAttempt++) {
            $this->beginTransaction($coupler);
            try {
                return tap($callback($this), function ($result) use ($coupler) {
                    $this->commit($coupler);
                });
            } catch (Exception $e) {
                $this->handleTransactionException($coupler, $e, $currentAttempt, $attempts);
            } catch (Throwable $e) {
                $this->rollBack($coupler);

                throw $e;
            }
        }
    }

    /**
     * Handle an exception encountered when running a transacted statement.
     *
     * @param DatabaseCoupler $coupler        coupler
     * @param \Exception      $e              exception
     * @param int             $currentAttempt current attempt
     * @param int             $maxAttempts    max attempts
     * @return void
     *
     * @throws \Exception
     */
    protected function handleTransactionException(DatabaseCoupler $coupler, $e, $currentAttempt, $maxAttempts)
    {
        // On a deadlock, MySQL rolls back the entire transaction so we can't just
        // retry the query. We have to throw this exception all the way out and
        // let the developer handle it in another way. We will decrement too.
        if ($this->causedByDeadlock($e) &&
            $this->globalTransactions > 1) {
            --$this->globalTransactions;

            throw $e;
        }

        // If there was an exception we will rollback this transaction and then we
        // can check if we have exceeded the maximum attempt count for this and
        // if we haven't we will return and try this query again in our loop.
        $this->rollBack($coupler);

        if ($this->causedByDeadlock($e) &&
            $currentAttempt < $maxAttempts) {
            return;
        }

        throw $e;
    }
}
