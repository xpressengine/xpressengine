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

use Xpressengine\Support\Singleton;
use Illuminate\Database\Connection;

/**
 * TransactionHandler
 *
 * * DatabaseHandler 에서 생성된 VirtualConnection 의 여러개의 database connection 을
 * 하나의 transaction 으로 관리
 *      - DatabaseHandler 에 의해 생성된 VirtualConnection 들의 transaction 관리
 *      - 각 VirtualConnection 가 갖는 connection 들은 연관성 없는 transaction 으로 처리됨
 *      - TransactionHandler 로 단일 connection 같이 처리
 *      - 하나 이상의 물리적으로 다른 connection 을 동일한 transaction 으로 처리
 *
 * ## 사용법
 *
 * ### Transaction
 * * VirtualConnection 통해 TransactionHandler 에서 처리
 *
 * ```php
 * XeDB::beginTransaction();
 * XeDB::commit();
 * XeDB::rollBack();
 * ```
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
}
