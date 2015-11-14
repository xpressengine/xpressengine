<?php
/**
 * SiteRepository
 *
 * PHP version 5
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Site;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Site\Exceptions\NotFoundSiteException;

/**
 * Class SiteRepository
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SiteRepository
{
    /**
     * @var VirtualConnectionInterface $conn
     */
    protected $conn;
    /**
     * Database table name of stored site
     *
     * @var string $table
     */
    protected $table = 'site';

    /**
     * constructor
     *
     * @param VirtualConnectionInterface $conn database connection instance
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * find
     *
     * @param string $host site unique host
     *
     * @return Site
     */
    public function find($host)
    {
        /**
         * @var Site $notification
         */
        $row = $this->conn->table($this->table)
            ->where('host', '=', $host)
            ->first();

        if (is_null($row)) {
            throw new NotFoundSiteException('Can not find Site');
        }

        return $this->createModel((array)$row);
    }

    /**
     * findBySiteKey
     *
     * @param string $siteKey site key string
     *
     * @return Site
     */
    public function findBySiteKey($siteKey)
    {
        /**
         * @var Site $notification
         */
        $row = $this->conn->table($this->table)
            ->where('siteKey', '=', $siteKey)
            ->first();

        if (is_null($row)) {
            throw new NotFoundSiteException('Can not find Site');
        }

        return $this->createModel((array)$row);
    }

    /**
     * insert
     *
     * @param Site $site site entity object
     *
     * @return Site
     */
    public function insert(Site $site)
    {
        $this->conn->table($this->table)->insert(
            $site->getAttributes()
        );

        return $this->createModel($site->getAttributes());
    }

    /**
     * update
     *
     * @param Site $site site entity object
     *
     * @return Site
     */
    public function update(Site $site)
    {
        $diff = $site->diff();

        if (count($diff) > 0) {
            $this->conn->table($this->table)->where('siteKey', $site->siteKey)->update($diff);
        }

        return $this->createModel(array_merge($site->getAttributes(), $diff));
    }

    /**
     * delete
     *
     * @param Site $site to delete
     *
     * @return int
     */
    public function delete(Site $site)
    {
        return $this->conn->table($this->table)->where('host', $site->host)->delete();
    }

    /**
     * count
     *
     * @param string $host site unique host
     *
     * @return int
     */
    public function count($host)
    {
        return $this->conn->table($this->table)->where('host', $host)->count();
    }

    /**
     * createModel
     *
     * @param array $attributes to create new Site object
     *
     * @return Site
     */
    private function createModel($attributes)
    {
        return new Site($attributes);
    }
}
