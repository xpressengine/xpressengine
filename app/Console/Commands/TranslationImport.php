<?php
/**
 * Translation command class. This file is part of the Xpressengine package.
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
use Xpressengine\Translation\LaravelLangData;
use Xpressengine\Translation\Translator;

/**
 * command
 *
 * ## 명령어 사용
 * ```
 * php artisan trans:import {pluginName}
 * ```
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TranslationImport extends Command
{

    /**
     * @var string
     */
    protected $name = 'translation:import';

    /**
     * @var string
     */
    protected $description = 'Translation data import to database';

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new command instance.
     *
     * @param Translator $translator translator
     */
    public function __construct(Translator $translator)
    {
        parent::__construct();

        $this->translator = $translator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->option('path');
        $force = $this->option('force');

        if ($path && !file_exists(base_path($path))) {
            $this->error(sprintf('Not exists [%s]', base_path($path)));
            return;
        }

        $files = [];
        if ($path && !is_dir(base_path($path))) {
            $files = [base_path($path)];
        } else {
            $dirPath = !$path ? $this->getLangsDir($name) : base_path($path);

            $dir = dir($dirPath);

            while ($entry = $dir->read()) {
                $path = $dirPath . DIRECTORY_SEPARATOR . $entry;
                if (is_dir($path)) {
                    continue;
                }
                $files[] = $path;

            }
        }

        foreach ($files as $file) {
            $this->translator->putFromLangDataSource($name, $file, $force);
        }

        if ($name === 'xe') {
            $this->translator->importLaravel($this->laravel->langPath(), $force);
        }

        $this->info('Language import complete!');
    }

    /**
     * Get the directory path where the language file
     *
     * @param string|null $name
     * @return string
     */
    protected function getLangsDir($name)
    {
        if ($name === 'xe') {
            // core language
            return base_path('resources') . DIRECTORY_SEPARATOR . 'lang';
        }

        return base_path('plugins') . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'langs';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the plugin', 'xe'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['path', null, InputOption::VALUE_OPTIONAL, 'The directory or file path for translation'],
            ['force', 'f', InputOption::VALUE_NONE, 'Update all translation data'],
        ];
    }
}
