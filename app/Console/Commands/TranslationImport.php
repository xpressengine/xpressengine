<?php
/**
 * TranslationImport.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * Class TranslationImport
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TranslationImport extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'translation:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translation data import to database';

    /**
     * Translator instance
     *
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
        $source = $this->resolveImportPath($name, $path);

        if ($source === false) {
            $this->error('Invalid path.');
            return 1;
        }

        $files = [];
        if (is_file($source)) {
            $files = [$source];
        } else {
            $dir = dir($source);

            while ($entry = $dir->read()) {
                $file = $source . DIRECTORY_SEPARATOR . $entry;
                if (is_dir($file)) {
                    continue;
                } elseif (strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'php') {
                    continue;
                }

                $files[] = $file;
            }
        }

        foreach ($files as $file) {
            $this->translator->putFromLangDataSource($name, $file, $force);
        }

        if ($name === 'xe') {
            $this->translator->importLaravel($this->laravel->langPath(), $force);
        }

        $this->info('Language import complete!');
        return 0;
    }

    /**
     * Get the directory path where the language file.
     *
     * @param string $name name of target
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
     * Resolve the import path under the allowed language directory.
     *
     * @param string      $name plugin name
     * @param string|null $path requested path
     *
     * @return string|false
     */
    protected function resolveImportPath($name, $path = null)
    {
        $allowedDir = realpath($this->getLangsDir($name));

        if ($allowedDir === false) {
            return false;
        }

        if ($name !== 'xe') {
            $pluginsDir = realpath(base_path('plugins'));
            if ($pluginsDir === false || !$this->isSameOrChildPath($allowedDir, $pluginsDir)) {
                return false;
            }
        }

        $realPath = realpath($path ? base_path($path) : $allowedDir);

        if ($realPath === false || !$this->isSameOrChildPath($realPath, $allowedDir)) {
            return false;
        }

        if (is_file($realPath) && strtolower(pathinfo($realPath, PATHINFO_EXTENSION)) !== 'php') {
            return false;
        }

        return $realPath;
    }

    /**
     * Check whether a path is a directory itself or one of its children.
     *
     * @param string $path      path
     * @param string $directory directory
     * @return bool
     */
    protected function isSameOrChildPath($path, $directory)
    {
        return $path === $directory || strpos($path, $directory . DIRECTORY_SEPARATOR) === 0;
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
