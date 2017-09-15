<?php
/**
 * Trash
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
use Symfony\Component\Console\Input\InputOption;
use Xpressengine\Trash\RecycleBinInterface;

/**
 * Trash
 *
 * 등록된 휴지통(recycle bin)의 요약 정보를 확인합니다
 *
 * ## 명령어 사용
 *
 * ### 전체 휴지통 요약 정보
 * ```
 * $ php artisan trash
 * ```
 *
 * ### 게시판 휴지통 정보 보기
 * ```
 * $ php artisan trash board
 * ```
 *
 * ### 댓글, 게시판의 요약 정보
 * ```
 * $ php artisan trash board,comment
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
class Trash extends Command
{

    /**
     * @var string
     */
    protected $name = 'trash';

    /**
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
     * @return mixed
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
