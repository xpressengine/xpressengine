<?php
/**
 * Translation command class. This file is part of the Xpressengine package.
 *
 * PHP version 5
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
use Xpressengine\Database\VirtualConnectionInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Xpressengine\Database\DatabaseHandler;
use Xpressengine\Translation\Translator;

/**
 * command
 *
 * ## 명령어 사용
 * ```
 * php artisan trans:put --path=path
 * ```
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PutTranslation extends Command
{

    /**
     * @var string
     */
    protected $name = 'trans';

    /**
     * @var string
     */
    protected $description = '다국어 파일을 database 에 넣습니다.';

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new command instance.
     *
     * @param Translator $translator translator
     */
    public function __construct(Translator $translator)
    {
        parent::__construct();

        $this->translator = $translator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $namespace = $this->input->getOption('ns');
        if ($namespace == false) {
            $this->error('네임스페이스를 입력하세요.');
            return null;
        }

        $path = $this->input->getOption('path');
        if ($path == false) {
            $this->error('다국어 파일 위치를 입력하세요.');
            return null;
        }

        $path = base_path($path);
        if (file_exists($path) === false) {
            $this->error('다국어 파일을 찾을 수 없습니다.');
            return null;
        }

        $this->translator->putFromLangDataSource($namespace, $path);

        $this->info('Language import complete!');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['ns', null, InputOption::VALUE_OPTIONAL, '네임스페이스'],
            ['path', null, InputOption::VALUE_OPTIONAL, '다국어 파일 경로'],
        ];
    }
}
