<?php
/**
 * Trash command class. This file is part of the Xpressengine package.
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
use Symfony\Component\Console\Input\InputArgument;

/**
 * TrashClean
 *
 * 등록된 휴지통(recycle bin)을 비웁니다.
 *
 * ## 명령어 사용
 *
 * ### 전체 휴지통 비우기
 * ```
 * $ php artisan trash:clean
 * ```
 *
 * ### 게시판 휴지통 비우기
 * ```
 * $ php artisan trash:clean board
 * ```
 *
 * ### 댓글, 게시판 비우기
 * ```
 * $ php artisan trash:clean board,comment
 * ```
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @see         Xpressengine\Trash\TrashManager manual
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TrashClean extends Trash
{

    /**
     * @var string
     */
    protected $name = 'trash:clean';

    /**
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
