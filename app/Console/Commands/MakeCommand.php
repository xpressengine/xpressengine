<?php
/**
 * MakeCommand.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Abstract Class MakeCommand
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class MakeCommand extends Command
{
    use ComposerRunTrait;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new component creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files instance
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Copy stub directory to given path
     *
     * @param string $path given path
     * @return void
     * @throws \Exception
     */
    protected function copyStubDirectory($path)
    {
        if ($this->files->isDirectory($path) && count($this->files->files($path, true)) > 0) {
            throw new \Exception("Destination path [$path] already exists and is not an empty directory.");
        }
        if (!$this->files->copyDirectory($this->getStubPath(), $path)) {
            throw new \Exception("Unable to create directory[$path]. please check permission.");
        }
    }

    /**
     * get stub path
     *
     * @return string
     */
    abstract protected function getStubPath();

    /**
     * Build the file with given parameters.
     *
     * @param string $file    file for build
     * @param array  $search  searches
     * @param array  $replace replaces
     * @param null   $to      location to move
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildFile($file, array $search, array $replace, $to = null)
    {
        $code = str_replace($search, $replace, $this->files->get($file));
        $this->files->put($file, $code);
        if ($to) {
            $this->files->move($file, $to);
        }
    }

    /**
     * Run composer dump command.
     *
     * @param string $path working directory
     * @return int
     * @throws \Exception
     */
    protected function runComposerDump($path)
    {
        $inputs = [
            'command' => 'dump-autoload',
            '--working-dir' => $path,
        ];

        return $this->runComposer($inputs, false);
    }
}
