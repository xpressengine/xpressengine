<?php
/**
 * TrashClean.php
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

/**
 * Class TrashClean
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @see         \Xpressengine\Trash\TrashManager
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TrashClean extends Trash
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'trash:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up the recycle bin.';

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
        $bins = $this->bins($names);

        $this->info('Clean up the recycle bin below.');
        $this->info('----------------------------------');
        parent::fire();
        $this->info('----------------------------------');

        if ($this->confirm('This action can not be undone. Do you want to continue? [yes|no]') == false) {
            $this->error('canceled');
            return null;
        }

        $trashManager = app('xe.trash');
        $trashManager->clean($bins);
    }
}
