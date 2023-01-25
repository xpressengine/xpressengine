<?php

/**
 * PluginMigrator.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Contributor - darron1217 <darron1217@gmail.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Plugin\Migrations;

use Illuminate\Database\Migrations\Migrator;

/**
 * Class PluginMigrator
 *
 * @category    Commands
 * @package     Xpressengine\Plugin\Migrations
 * @author      darron1217 (developers) <darron1217@gmail.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginMigrator extends Migrator
{
    /**
     * Rollback for Plugin
     *
     * @param array|string $paths
     * @param array $options
     * @param array $fileList
     * @return array
     */
    public function rollbackForPlugin($paths = [], array $options = [], array $fileList = [])
    {
        $this->notes = [];
        $migrations = $this->getMigrationsForRollback($options);

        // 플러그인 폴더에 있는 마이그레이션 파일만 찾음
        $migrations = collect($migrations)->intersect($fileList)->all();

        if (count($migrations) === 0) {
            $this->note('<info>Nothing to rollback.</info>');
            return [];
        }

        return $this->rollbackMigrations($migrations, $paths, $options);
    }

    /**
     * Reset for Plugin
     *
     * @param array|string $paths
     * @param  bool  $pretend
     * @param  array  $fileList
     * @return array
     */
    public function resetForPlugin($paths = [], bool $pretend = false, array $fileList = [])
    {
        $this->notes = [];
        $migrations = array_reverse($this->repository->getRan());

        // 플러그인 폴더에 있는 마이그레이션 파일만 찾음
        $migrations = collect($migrations)->intersect($fileList)->all();

        if (count($migrations) === 0) {
            $this->note('<info>Nothing to rollback.</info>');
            return [];
        }

        return $this->resetMigrations($migrations, $paths, $pretend);
    }
}