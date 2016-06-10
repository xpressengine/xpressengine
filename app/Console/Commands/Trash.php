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
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
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
 * trash [<action>] [<wastes>]
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
 * php artisan trash clean
 *
 * // 게시판 휴지통 비우기
 * php artisan trash clean board
 * ```
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @see         Xpressengine\Trash\TrashManager manual
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
    protected $description = '휴지통의 정보를 확인하고 휴지통을 비울 수 있습니다.';

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
            case 'clean':
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
        $this->info('아래의 휴지통을 비웁니다.');
        $this->info('----------------------------------');
        $this->summary($args);
        $this->info('----------------------------------');

        if ($this->confirm('이 동작은 실행 취소할 수 없습니다. 게속하시겠습니까? [yes|no]') == false) {
            $this->error('취소 되었습니다.');
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
            $this->error('처리할 휴지통이 없습니다.');
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
            ['action', InputArgument::OPTIONAL, '"summary" 등록된 휴지통의 요약정보. "clean" 등록된 휴지통들을 비웁니다.', 'summary'],
            ['wastes', InputArgument::OPTIONAL, '휴지통 이름. 콤마(,) 로 구분하여 여러개의 이름을 지정할 수 있다.'],
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
