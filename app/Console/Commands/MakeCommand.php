<?php
/**
 * MakeCommand.php
 *
 * PHP version 7
 *
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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
     * @param  \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * copy stub directory to given path
     *
     * @param string $path
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
     * build the file with given parameters
     *
     * @param string $file
     * @param array $search
     * @param array $replace
     * @param null $to
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
     * run composer dump
     *
     * @param string $path
     * @return int
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
