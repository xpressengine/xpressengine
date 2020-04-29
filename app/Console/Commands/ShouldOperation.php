<?php
/**
 * ShouldOperation.php
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

use App\Console\MultipleOutput;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Xpressengine\Foundation\Operator;

/**
 * Class ShouldOperation
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class ShouldOperation extends Command
{
    use ComposerRunTrait;

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
        $datetime = Carbon::now()->format('YmdHis');
        $file = "logs/operation-{$datetime}.log";
        $path = $this->laravel->storagePath().DIRECTORY_SEPARATOR.$file;

        $output = new MultipleOutput([$output, new StreamOutput(fopen($path, 'a'))]);

        \Log::useFiles($path);

        $this->operator->log($file);
        $this->operator->save();

        return parent::run($input, $output);
    }

    /**
     * Start the operation
     *
     * @param string        $mode     operation mode
     * @param callable      $callback callback
     * @param callable|null $onError  callback for error
     * @return void
     * @throws \Throwable
     */
    protected function start($mode, callable $callback, callable $onError = null)
    {
        $this->operator->lock();

        $method = 'set'.ucfirst($mode).'Mode';
        $this->operator->$method();

        $this->operator->expiresAt(Carbon::now()->addSeconds($limit = $this->getTimeLimit())->toDateTimeString());
        $this->operator->save();

        set_time_limit($limit);

        try {
            if (0 !== $code = $this->clearCache(true)) {
                throw new \RuntimeException('cache clear fail.. check your system.', $code);
            }

            call_user_func($callback, $this->operator);
        } catch (\Exception $e) {
            $this->errorHandle($e, $onError);
        } catch (\Throwable $e) {
            $this->errorHandle($e, $onError);
        } finally {
            $this->operator->unlock();
        }

        $this->setSucceed();
    }

    /**
     * Handle error for the operation.
     *
     * @param \Throwable    $e        exception
     * @param callable|null $callback callback
     * @return void
     * @throws \Throwable
     */
    protected function errorHandle($e, callable $callback = null)
    {
        $this->setFailed($e->getCode());
        if ($callback) {
            call_user_func($callback, $e);
        }

        throw $e;
    }

    /**
     * Start the core operation
     *
     * @param callable      $callback callback
     * @param callable|null $onError  callback for error
     * @return void
     * @throws \Throwable
     */
    protected function startCore(callable $callback, callable $onError = null)
    {
        $this->start(Operator::TYPE_CORE, $callback, $onError);
    }

    /**
     * Start the plugin operation
     *
     * @param callable      $callback callback
     * @param callable|null $onError  callback for error
     * @return void
     * @throws \Throwable
     */
    protected function startPlugin(callable $callback, callable $onError = null)
    {
        $this->start(Operator::TYPE_PLUGIN, $callback, $onError);
    }

    /**
     * Start the private plugin operation
     *
     * @param callable      $callback callback
     * @param callable|null $onError  callback for error
     * @return void
     * @throws \Throwable
     */
    protected function startPrivate(callable $callback, callable $onError = null)
    {
        $this->start(Operator::TYPE_PRIVATE, $callback, $onError);
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
        $operation = $this->operator->getOperation();
        $result !== 0 ? $operation->failed() : $operation->succeed();
        $this->operator->save();
    }
}
