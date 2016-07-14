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
 * command
 *
 * ## 명령어 사용
 * ```
 * trash:empty [<action>] [<wastes>]
 * ```
 *
 * ### 등록된 휴지통(waste) 의 요약 정보
 * ```
 * // 전체 휴지통 요약 정보
 * php artisan trash
 * php artisan trash summary
 *
 * // 게시판 휴지통 정보 보기
 * php artisan trash summary board
 * ```
 *
 * ### 등록된 휴지통(waste) 비우기
 * ```
 * // 전체 휴지통 비우기
 * php artisan trash empty
 *
 * // 게시판 휴지통 비우기
 * php artisan trash empty board
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
class TrashEmpty extends Command
{

    /**
     * @var string
     */
    protected $name = 'trash';

    /**
     * @var string
     */
    protected $description = 'Find information about the recycle bin and can empty the recycle bin';

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
    public function fire()
    {
        $args = $this->argument();

        switch ($args['action']) {
            case 'summary':
                $this->summary($args);
                break;
            case 'empty':
                $this->clean($args);
                break;
            default:
                $args['waste'] = $args['action'];
                $this->summary($args);
                break;
        }
    }

    /**
     * Dump trash
     *
     * @param array $args arguments
     * @return void
     */
    private function clean($args)
    {
        $this->info('Empty the recycle bin below.');
        $this->info('----------------------------------');
        $this->summary($args);
        $this->info('----------------------------------');

        if ($this->confirm('This action can not be undone. Do you want to continue? [yes|no]') == false) {
            $this->error('canceled');
            return null;
        }

        $trashManager = app('xe.trash');
        $trashManager->clean($this->waste($args));
    }

    /**
     * show trash informations
     *
     * @param array $args arguments
     * @return void
     */
    private function summary($args)
    {
        foreach ($this->waste($args) as $basket) {
            $this->info('    name: ' . $basket::name());
            $this->info('        summary: ' . $basket::summary());
        }
    }

    /**
     * option 에 의해 지정된 휴지통의 class 를 반환
     *
     * @param array $args arguments
     * @return array
     */
    private function waste($args)
    {
        /** @var \Xpressengine\Trash\TrashManager $trashManager */
        $trashManager = app('xe.trash');

        $wastes = [];
        $names = [];
        if (isset($args['wastes'])) {
            foreach (explode(',', $args['wastes']) as $name) {
                $names[] = $name;
            }
        }

        foreach ($trashManager->gets() as $waste) {
            if (in_array($waste::name(), $names)) {
                $wastes[] = $waste;
            }
        }

        if (count($wastes) == 0) {
            $this->error('There is no recycle bin to be processed.');
        }

        return $wastes;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['action', InputArgument::OPTIONAL, '"summary" Get summary. "empty" Empty recycle bin.', 'summary'],
            ['wastes', InputArgument::OPTIONAL, 'Names of Recycle bin. It is possible to specify multiple names, separated by commas.'],
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
        ];
    }
}
