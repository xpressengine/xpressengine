<?php

namespace App\Console\Commands;

class PluginPrivateInstall extends PluginCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:private_install {name : The name of the plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app('path.privates') . DIRECTORY_SEPARATOR . $name;

        $this->startPrivate(function () use ($name, $path) {
            $this->writeRequire('install', [
                ['name' => $packageName = 'xpressengine-plugin/' . $name, 'version' => '*']
            ]);

            $this->composerUpdate([$packageName]);
        });
    }
}
