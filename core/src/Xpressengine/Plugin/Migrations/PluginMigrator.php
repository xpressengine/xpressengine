<?php

namespace Xpressengine\Plugin\Migrations;

use Illuminate\Database\Migrations\Migrator;

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
    public function rollbackForPlugin($paths = [], array $options = [], $fileList = [])
    {
        $this->notes = [];

        // We want to pull in the last batch of migrations that ran on the previous
        // migration operation. We'll then reverse those migrations and run each
        // of them "down" to reverse the last migration "operation" which ran.
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
     * @param bool $pretend
     * @param array $fileList
     * @return array
     */
    public function resetForPlugin($paths = [], $pretend = false, $fileList = [])
    {
        $this->notes = [];

        // Next, we will reverse the migration list so we can run them back in the
        // correct order for resetting this database. This will allow us to get
        // the database back into its "empty" state ready for the migrations.
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
