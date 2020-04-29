<?php
/**
 * MultipleOutput.php
 *
 * PHP version 7
 *
 * @category    Console
 * @package     App\Console
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Console;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MultipleOutput
 *
 * @category    Console
 * @package     App\Console
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MultipleOutput implements OutputInterface
{
    /**
     * The output instances.
     *
     * @var OutputInterface[]
     */
    protected $outputs;

    /**
     * MultipleOutput constructor.
     *
     * @param OutputInterface[] $outputs output instances.
     */
    public function __construct(array $outputs)
    {
        $this->outputs = $outputs;
    }

    /**
     * Writes a message to the output.
     *
     * @param string|array $messages The message as an array of strings or a single string
     * @param bool $newline Whether to add a newline
     * @param int $options A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
     * @return void
     */
    public function write($messages, $newline = false, $options = 0)
    {
        foreach ($this->outputs as $output) {
            $output->write($messages, $newline, $options);
        }
    }

    /**
     * Writes a message to the output and adds a newline at the end.
     *
     * @param string|array $messages The message as an array of strings or a single string
     * @param int $options A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
     * @return void
     */
    public function writeln($messages, $options = 0)
    {
        $this->write($messages, true, $options);
    }

    /**
     * Sets the verbosity of the output.
     *
     * @param int $level The level of verbosity (one of the VERBOSITY constants)
     * @return void
     */
    public function setVerbosity($level)
    {
        foreach ($this->outputs as $output) {
            $output->setVerbosity($level);
        }
    }

    /**
     * Gets the current verbosity of the output.
     *
     * @return int The current level of verbosity (one of the VERBOSITY constants)
     */
    public function getVerbosity()
    {
        if (!$output = $this->rep()) {
            return static::VERBOSITY_NORMAL;
        }

        return $output->getVerbosity();
    }

    /**
     * Returns whether verbosity is quiet (-q).
     *
     * @return bool true if verbosity is set to VERBOSITY_QUIET, false otherwise
     */
    public function isQuiet()
    {
        if (!$output = $this->rep()) {
            return false;
        }

        return $output->isQuiet();
    }

    /**
     * Returns whether verbosity is verbose (-v).
     *
     * @return bool true if verbosity is set to VERBOSITY_VERBOSE, false otherwise
     */
    public function isVerbose()
    {
        if (!$output = $this->rep()) {
            return false;
        }

        return $output->isVerbose();
    }

    /**
     * Returns whether verbosity is very verbose (-vv).
     *
     * @return bool true if verbosity is set to VERBOSITY_VERY_VERBOSE, false otherwise
     */
    public function isVeryVerbose()
    {
        if (!$output = $this->rep()) {
            return false;
        }

        return $output->isVeryVerbose();
    }

    /**
     * Returns whether verbosity is debug (-vvv).
     *
     * @return bool true if verbosity is set to VERBOSITY_DEBUG, false otherwise
     */
    public function isDebug()
    {
        if (!$output = $this->rep()) {
            return false;
        }

        return $output->isDebug();
    }

    /**
     * Sets the decorated flag.
     *
     * @param bool $decorated Whether to decorate the messages
     * @return void
     */
    public function setDecorated($decorated)
    {
        foreach ($this->outputs as $output) {
            $output->setDecorated($decorated);
        }
    }

    /**
     * Gets the decorated flag.
     *
     * @return bool true if the output will decorate messages, false otherwise
     */
    public function isDecorated()
    {
        if (!$output = $this->rep()) {
            return false;
        }

        return $output->isDecorated();
    }

    /**
     * Set the output formatter instance.
     *
     * @param OutputFormatterInterface $formatter output formatter instance.
     * @return void
     */
    public function setFormatter(OutputFormatterInterface $formatter)
    {
        foreach ($this->outputs as $output) {
            $output->setFormatter($formatter);
        }
    }

    /**
     * Returns current output formatter instance.
     *
     * @return OutputFormatterInterface
     */
    public function getFormatter()
    {
        if (!$output = $this->rep()) {
            return new OutputFormatter();
        }

        return $output->getFormatter();
    }

    /**
     * Returns the representation output.
     *
     * @return false|OutputInterface
     */
    protected function rep()
    {
        return reset($this->outputs);
    }
}
