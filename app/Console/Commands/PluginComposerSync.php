<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xpressengine\Plugin\Composer\ComposerFileWriter;

class PluginComposerSync extends Command
{
    /**
     * The console command name.
     * php artisan plugin:sync-composer
     *
     * @var string
     */
    protected $signature = 'plugin:sync-composer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync plugins' composer.json with real plugin list";

    /**
     * Create a new controller creator command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ComposerFileWriter $writer
     *
     * @return bool|null
     * @throws \Exception
     */
    public function handle(ComposerFileWriter $writer)
    {
        // php artisan plugin:sync-composer

        // sync
        $writer->resolvePlugins()->setFixMode()->write();

        $this->output->success("The installation information of the plug-in was synchronized with the composer file(".$writer->getPath().").");
    }
}
