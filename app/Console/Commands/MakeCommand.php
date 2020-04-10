<?php
/**
 * MakeCommand.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Xpressengine\Foundation\Operator;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

/**
 * Abstract Class MakeCommand
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class MakeCommand extends PluginCommand
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new component creator command instance.
     *
     * @param Filesystem     $files    Filesystem instance
     * @param Operator       $operator Operator instance
     * @param PluginHandler  $handler  PluginHandler
     * @param PluginProvider $provider PluginProvider
     */
    public function __construct(Filesystem $files, Operator $operator, PluginHandler $handler, PluginProvider $provider)
    {
        parent::__construct($operator, $handler, $provider);

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
     *
     * @deprecated since 3.0.1
     */
    protected function runComposerDump($path)
    {
        return $this->composerDump($path);
    }
}
