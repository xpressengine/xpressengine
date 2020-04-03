<?php

namespace App\Console\Commands;

use App\Facades\XeDB;
use Illuminate\Console\Command;

class CharsetConvert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xe:convert-charset
                            {charset=utf8mb4 : Specify the charset for converting}
                            {collation=utf8mb4_unicode_ci : Specify the collation for converting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert database character set and collation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");

        $charset = $this->argument('charset');
        $collation = $this->argument('collation');

        // XpressEngine과 연결된 데이터베이스의 문자셋 변경
        XeDB::unprepared("ALTER SCHEMA {$database} DEFAULT CHARACTER SET {$charset} DEFAULT COLLATE {$collation};");

        // 데이터베이스에 속한 테이블의 문자셋 변경
        $tables = XeDB::select("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = '{$database}'");
        $tables = array_map(function ($value) {
            return (array)$value;
        }, $tables);

        foreach ($tables as $table) {
            XeDB::unprepared("ALTER TABLE {$table['TABLE_NAME']} CONVERT TO CHARACTER SET {$charset} COLLATE {$collation};");
        }
    }
}
