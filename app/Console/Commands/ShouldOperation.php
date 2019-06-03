<?php
/**
 * ShouldOperation.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use App\Console\MultipleOutput;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Xpressengine\Foundation\Operator;

/**
 * Class ShouldOperation
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class ShouldOperation extends Command
{
    use ComposerRunTrait {
        ComposerRunTrait::runComposer as doRunComposer;
    }

    /**
     * Operator instance
     *
     * @var Operator
     */
    protected $operator;

    /**
     * ShouldOperation constructor.
     *
     * @param Operator $operator Operator instance
     */
    public function __construct(Operator $operator)
    {
        parent::__construct();

        $this->operator = $operator;
    }

    /**
     * Run the console command.
     *
     * @param InputInterface  $input  input
     * @param OutputInterface $output output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        if ($output instanceof ConsoleOutputInterface) {
            $logFile = 'logs/operation-'.Carbon::now()->format('YmdHis').'.log';
            $path = $this->laravel->storagePath().DIRECTORY_SEPARATOR.$logFile;

            $output = new MultipleOutput([$output, new StreamOutput(fopen($path, 'a'))]);

            $this->operator->log($logFile);
            $this->operator->write();
        }

        if ($file = $this->operator->getLogFile()) {
            \Log::useFiles($this->laravel->storagePath().DIRECTORY_SEPARATOR.$file);
        }

        return parent::run($input, $output);
    }

    /**
     * Execute composer update.
     *
     * @param array $packages specific package name. no need version
     * @return int
     * @throws \Exception
     * @throws \Throwable
     */
    protected function composerUpdate(array $packages)
    {
        if (!$this->operator->isLocked()) {
            $this->operator->lock();
        }

        $this->setExpires();

        try {
            if (0 !== $this->clearCache(true)) {
                throw new \Exception('cache clear fail.. check your system.');
            }

            $this->prepareComposer();

            $inputs = [
                'command' => 'update',
                "--with-dependencies" => true,
                '--working-dir' => base_path(),
                'packages' => $packages
            ];

            $this->writeResult($result = $this->runComposer($inputs, false, $this->output));

            return $result;
        } catch (\Exception $e) {
            $this->setFailed($e->getCode());
            throw $e;
        } catch (\Throwable $e) {
            $this->setFailed($e->getCode());
            throw new FatalThrowableError($e);
        } finally {
            $this->operator->unlock();
        }
    }

    /**
     * Run composer dump command.
     *
     * @param string $path working directory
     * @return int
     * @throws \Exception
     */
    protected function composerDump($path)
    {
        $inputs = [
            'command' => 'dump-autoload',
            '--working-dir' => $path,
        ];

        $this->writeResult($result = $this->runComposer($inputs, false, $this->output));

        return $result;
    }

    /**
     * Run composer
     *
     * @param array                       $inputs     input arguments
     * @param bool                        $skipPlugin if true, xe plugin is skip
     * @param OutputInterface|string|null $output     output
     * @return int
     * @throws \Exception
     */
    protected function runComposer($inputs, $skipPlugin = false, $output = null)
    {
        if (!$this->laravel->runningInConsole()) {
            ignore_user_abort(true);
            set_time_limit($this->getExpiredTime());
        }

        return $this->doRunComposer($inputs, $skipPlugin, $output);
    }

    /**
     * Run cache clear.
     *
     * @param bool $exceptProxy except proxy when clears the cache
     * @return int
     */
    protected function clearCache($exceptProxy = false)
    {
        $this->warn('Clears the cache before the operation run.');
        $result = $this->call('cache:clear', ['--except-proxy' => $exceptProxy]);
        $this->line(PHP_EOL);

        return $result;
    }

    /**
     * Set the operation expires.
     *
     * @return void
     */
    protected function setExpires()
    {
        $expiresAt = !$this->laravel->runningInConsole() ?
            Carbon::now()->addSeconds($this->getExpiredTime())->toDateTimeString() : null;

        $this->operator->expiresAt($expiresAt);
        $this->operator->write();
    }

    /**
     * Get expired time.
     *
     * @return int|string
     */
    protected function getExpiredTime()
    {
        return $this->laravel->runningInConsole() ? 0 : $this->getTimeLimit();
    }

    /**
     * Get time limit.
     *
     * @return int
     */
    protected function getTimeLimit()
    {
        return config('xe.plugin.operation.time_limit');
    }

    /**
     * Set operation succeed.
     *
     * @return void
     */
    protected function setSucceed()
    {
        $this->writeResult(0);
    }

    /**
     * Set operation failed.
     *
     * @param int $code result code
     * @return void
     */
    protected function setFailed($code = 1)
    {
        $this->writeResult($code === 0 ? 1 : $code);
    }

    /**
     * Write result.
     *
     * @param int $result result code
     * @return void
     */
    protected function writeResult($result)
    {
        // composer 동작이 완료되는 시점에서 쓰기 작업을 수행하므로
        // 결과를 기록하기 전에 파일을 다시 읽어들인다.
        // @todo : Composer::postUpdateOrInstall 실행시 operation 작성코드가 제거됨. 다시 load 필요한지 확인.
        $this->operator->load();

        $operation = $this->operator->getOperation();
        $result !== 0 ? $operation->failed() : $operation->succeed();
        $this->operator->write();
    }
}
