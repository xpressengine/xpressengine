<?php
/**
 * This file is storage division in a round robin schema
 *
 * PHP version 5
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Storage;

use Xpressengine\Database\VirtualConnectionInterface;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

/**
 * 순차적으로 지정된 저장소마다 돌아가면서 저장시키는 방식으로 저장소를 지정
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class RoundRobinDistributor implements Distributor
{
    /**
     * filesystem config
     *
     * @var array
     */
    protected $config;

    /**
     * database connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * table name
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * constructor
     *
     * @param array                      $config filesystem config
     * @param VirtualConnectionInterface $conn   database connection instance
     */
    public function __construct(array $config, VirtualConnectionInterface $conn)
    {
        $this->config = $config;
        $this->conn = $conn;
    }

    /**
     * allot storage disk
     *
     * @param SymfonyFile $file file object
     * @return string
     */
    public function allot(SymfonyFile $file)
    {
        if ($this->config['division']['enable'] === true) {
            $row = $this->lastRecord();
            return $row === null ? $this->config['division']['disks'][0] : $this->next($row['disk']);
        }

        return $this->config['default'];
    }

    /**
     * get last table record
     *
     * @return array|null
     */
    private function lastRecord()
    {
        $row = $this->conn->table($this->table)->orderBy('created_at', 'desc')->first();

        return $row ? (array)$row : null;
    }

    /**
     * disk in the next
     *
     * @param string $name last used disk name
     * @return string
     */
    private function next($name)
    {
        $disks = $this->config['division']['disks'];
        $key = array_search($name, $disks);
        $key = ++$key > count($disks) - 1 ? 0 : $key;

        return $disks[$key];
    }
}
