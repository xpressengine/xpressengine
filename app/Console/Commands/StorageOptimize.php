<?php
/**
 * StorageOptimize.php
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

use Illuminate\Console\Command;
use Xpressengine\Storage\Storage;

/**
 * Class StorageOptimize
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class StorageOptimize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the unused files';

    /**
     * Storage instance
     *
     * @var Storage
     */
    protected $storage;

    /**
     * The memory bag.
     *
     * @var array
     */
    protected $bag = [];

    /**
     * Create a new command instance.
     *
     * @param Storage $storage Storage instance
     */
    public function __construct(Storage $storage)
    {
        parent::__construct();

        $this->storage = $storage;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        if ($this->getOutput()->getVerbosity() > 1) {
            $this->intercept();
        }

        $loop = 0;
        try {
            while(true) {
                $files = $this->storage->where('use_count', 0)->where('origin_id', null)->paginate(20);
                if (count($files) < 1) {
                    break;
                }

                foreach ($files as $file) {
                    $this->storage->delete($file);
                }

                sleep(1);
                $loop++;


                if ($loop > 100) {
                    throw new \Exception('loop over 100 times');
                }
            }

            $this->info('Done..');
        } catch (\Exception $e) {
            $this->error('Process error, stopped command');
            throw $e;
        } finally {
            $this->output();
        }

    }

    /**
     * Register intercept event for log.
     *
     * @return void
     */
    private function intercept()
    {
        intercept('XeStorage@delete', 'storage.optimize.log', function ($target, $file) {

            $this->bag[] = $file;

            return $target($file);
        });
    }

    /**
     * Print output.
     *
     * @return void
     */
    private function output()
    {
        $verbosity = $this->getOutput()->getVerbosity();

        if ($verbosity > 1) {
            $this->comment('Deleted:');
        }

        foreach ($this->bag as $file) {
            switch ($verbosity) {
                case 2:
                    if ($file->origin_id === null) {
                        $this->info("\t" . $file->clientname);
                    }
                    break;
                case 3:
                    if ($file->origin_id === null) {
                        $this->line("\t" .
                            $file->disk . "\t" .
                            "<info>" . $file->clientname . "</info>\t" .
                            bytes($file->size)
                        );
                    }
                    break;
                case 4:
                    $this->line("\t" .
                        $file->disk . "\t" .
                        "<info>" . $file->clientname . "</info>\t" .
                        bytes($file->size)
                    );
                    break;

            }
        }
    }
}
