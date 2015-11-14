<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		\App\Console\Commands\Inspire::class,
		/*\App\Console\Commands\AOPParser::class,*/
		\App\Console\Commands\Trash::class,
		\App\Console\Commands\Schema::class,
		\App\Console\Commands\PutTranslation::class,
		\App\Console\Commands\XeCacheClear::class,
		\App\Console\Commands\StorageOptimize::class,
		\App\Console\Commands\Site::class,
		\App\Console\Commands\PluginMakeCommand::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')
			->hourly();
	}
}
