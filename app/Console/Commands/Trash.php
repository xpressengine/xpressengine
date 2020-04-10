<?php
/**
 * Trash.php
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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Xpressengine\Trash\RecycleBinInterface;

/**
 * Class Trash
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @see         \Xpressengine\Trash\TrashManager
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Trash extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'trash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get summary about the recycle bin.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $names = $this->input->getArgument('names');

        /** @var RecycleBinInterface $bin */
        foreach ($this->bins($names) as $bin) {
            $this->info('    name: ' . $bin::name());
            $this->info('        summary: ' . $bin::summary());
        }
    }

    /**
     * option 에 의해 지정된 휴지통의 class 를 반환
     *
     * @param array $names recycle bin name
     * @return array
     */
    protected function bins($names)
    {
        /** @var \Xpressengine\Trash\TrashManager $trashManager */
        $trashManager = app('xe.trash');

        $bins = [];
        if ($names !== null) {
            foreach (explode(',', $names) as $name) {
                $bins[] = $trashManager->get($name);
            }
        } else {
            $bins = $trashManager->bins();
        }

        if (count($bins) == 0) {
            $this->error('There is no recycle bin to be processed.');
        }

        return $bins;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['names', InputArgument::OPTIONAL, 'Names of Recycle bin. It is possible to specify multiple names, separated by commas.'],
        ];
    }
}
