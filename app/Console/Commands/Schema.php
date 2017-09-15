<?php
/**
 * Database command class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xpressengine\Database\VirtualConnectionInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Xpressengine\Database\DatabaseHandler;

/**
 * command
 *
 * ## 명령어 사용
 * ```
 * php artisan db:schema-cache --tables=tableName1,tableName2...
 * ```
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Schema extends Command
{

    /**
     * @var string
     */
    protected $name = 'db:schema-cache';

    /**
     * @var string
     */
    protected $description = 'Cache database table schema';

    /**
     * @var DatabaseHandler
     */
    protected $databaseHandler;

    /**
     * Create a new command instance.
     *
     * @param DatabaseHandler $databaseHandler database handler
     */
    public function __construct(DatabaseHandler $databaseHandler)
    {
        parent::__construct();

        $this->databaseHandler = $databaseHandler;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tables = $this->input->getOption('tables');
        if ($tables == false) {
            $this->error('Cannot find table name.');
        }

        $tables = explode(',', $tables);
        if (count($tables) == 0) {
            $this->error('Cannot find table name.');
        }

        $config = $this->databaseHandler->getConfig();

        // 어떤 connection 에 table 이 있는지 알 수 없음
        $connectors = [];
        foreach ($config as $name => $settings) {
            $connectors[] = $this->databaseHandler->connection($name);
        }

        $cacheNames = [];
        /** @var \Xpressengine\Database\VirtualConnectionInterface $connector */
        foreach ($connectors as $connector) {
            foreach ($tables as $table) {
                if (in_array($table, $cacheNames) === true) {
                    continue;
                }

                if ($connector->setSchemaCache($table, true) === true) {
                    $cacheNames[] = $table;
                }
            }
        }

        if (count($cacheNames) === 0) {
            $this->error('Cannot find table name. Please check database table name');
        } else {
            $this->info(implode(',', array_unique($cacheNames)) . ' database tables cached.');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['tables', null, InputOption::VALUE_OPTIONAL,
                'Destination table name. Separated by a comma(,) you can specify multiple names.'],
        ];
    }
}
