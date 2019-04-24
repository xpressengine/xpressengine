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
use Xpressengine\Installer\XpressengineInstaller;
use Xpressengine\Plugin\Composer\ComposerFileWriter;

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
     * ComposerFileWriter instance
     *
     * @var ComposerFileWriter
     */
    protected $writer;

    /**
     * ShouldOperation constructor.
     *
     * @param ComposerFileWriter $writer ComposerFileWriter instance
     */
    public function __construct(ComposerFileWriter $writer)
    {
        parent::__construct();

        $this->writer = $writer;
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

            $this->writer->set('xpressengine-plugin.operation.log', $logFile);
            $this->writer->write();
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
        if ($this->isLocked()) {
            throw new \Exception('The command is locked. Make sure that another process is running.');
        }

        $this->lock();

        try {
            if (0 !== $this->clearCache(true)) {
                throw new \Exception('cache clear fail.. check your system.');
            }

            $this->prepareComposer();

            $inputs = [
                'command' => 'update',
                "--with-dependencies" => true,
                //"--quiet" => true,
                '--working-dir' => base_path(),
                /*'--verbose' => '3',*/
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
            $this->unlock();
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
            set_time_limit($time = $this->getExpiredTime());
            $this->writer->setExpiresAt(Carbon::now()->addSeconds($time)->toDateTimeString());
        } else {
            $this->writer->setExpiresAt(null);
        }

        if (!$this->writer->isRunning()) {
            $this->writer->setRunning();
        }

        $this->writer->write();

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
     * Determine if operation is locked.
     *
     * @return bool
     */
    protected function isLocked()
    {
        $this->writer->load();
        return $this->writer->get('xpressengine-plugin.lock', false);
    }

    /**
     * Locks a operation.
     *
     * @return void
     */
    protected function lock()
    {
        $this->writer->set('xpressengine-plugin.lock', true);
        $this->writer->write();
    }

    /**
     * Unlocks a operation.
     *
     * @return void
     */
    protected function unlock()
    {
        $this->writer->set('xpressengine-plugin.lock', false);
        $this->writer->write();
    }

    /**
     * Set operation successed.
     *
     * @return void
     */
    protected function setSuccessed()
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
        // composer.plugins.json 파일을 다시 읽어들인다.
        $this->writer->load();
        if ($result !== 0) {
            $this->writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_FAILED);
            $this->writer->set('xpressengine-plugin.operation.failed', XpressengineInstaller::$failed);
        } else {
            $this->writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_SUCCESSED);
        }
        $this->writer->write();
    }
}
