<?php

namespace KORD;

use KORD\Log;
use KORD\Log\Writer as LogWriter;
use KORD\Log\Level as LogLevel;
use Psr\Log\InvalidArgumentException;

/**
 * Message logging with observer-based log writing.
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
class LogSrc extends \Psr\Log\AbstractLogger
{
    
    /**
     * @var  boolean  immediately write when logs are added
     */
    public static $write_on_add = false;

    /**
     * @var  array  list of added messages
     */
    protected $messages = [];

    /**
     * @var  array  list of log writers
     */
    protected $writers = [];
    
    /**
     * Construct \KORD\Log object
     */
    public function __construct()
    {
        // Write the logs at shutdown
        register_shutdown_function([$this, 'write']);
    }

    /**
     * Attaches a log writer, and optionally limits the levels of messages that
     * will be written by the writer.
     *
     *     $log->attach($writer);
     *
     * @param   \KORD\Log\Writer  $writer     instance
     * @param   mixed       $levels     array of messages levels to write OR max level to write
     * @return  Log
     */
    public function attach(LogWriter $writer, $levels = [])
    {
        $this->writers["{$writer}"] = [
            'object' => $writer,
            'levels' => $levels
        ];

        return $this;
    }

    /**
     * Detaches a log writer. The same writer object must be used.
     *
     *     $log->detach($writer);
     *
     * @param   \KORD\Log\Writer  $writer instance
     * @return  Log
     */
    public function detach(LogWriter $writer)
    {
        // Remove the writer
        unset($this->writers["{$writer}"]);

        return $this;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @param   array   $additional  additional custom parameters to supply to the log writer
     * @return null
     */
    public function log($level, $message, array $context = [], array $additional = null)
    {
        // PSR-3 states that $message should be a string
        $message = (string) $message;

        // PSR-3 states that we must throw a
        // Psr\Log\InvalidArgumentException if we don't
        // recognize the level
        if (!in_array($level, LogLevel::$levels)) {
            throw new InvalidArgumentException("Unknown severity level");
        }

        if ($context) {
            $message = $this->interpolate($message, $context);
        }
        
        // Grab a copy of the trace
        if (isset($additional['exception'])) {
            $trace = $additional['exception']->getTrace();
        } else {
            $trace = array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), 1);
        }

        if ($additional == null) {
            $additional = [];
        }

        // Create a new message
        $this->messages[] = [
            'time' => time(),
            'level' => $level,
            'body' => $message,
            'trace' => $trace,
            'file' => isset($trace[0]['file']) ? $trace[0]['file'] : null,
            'line' => isset($trace[0]['line']) ? $trace[0]['line'] : null,
            'class' => isset($trace[0]['class']) ? $trace[0]['class'] : null,
            'function' => isset($trace[0]['function']) ? $trace[0]['function'] : null,
            'additional' => $additional,
        ];

        if (Log::$write_on_add) {
            // Write logs as they are added
            $this->write();
        }

        return $this;
    }

    /**
     * Interpolates context values into the message placeholders.
     * According to PSR-3
     */
    protected function interpolate($message, array $context = [])
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }

    /**
     * Write and clear all of the messages.
     *
     *     $log->write();
     *
     * @return  void
     */
    public function write()
    {
        if (empty($this->messages)) {
            // There is nothing to write, move along
            return;
        }

        // Import all messages locally
        $messages = $this->messages;

        // Reset the messages array
        $this->messages = [];

        foreach ($this->writers as $writer) {
            if (empty($writer['levels'])) {
                // Write all of the messages
                $writer['object']->write($messages);
            } else {
                // Filtered messages
                $filtered = [];

                foreach ($messages as $message) {
                    if (in_array($message['level'], $writer['levels'])) {
                        // Writer accepts this kind of message
                        $filtered[] = $message;
                    }
                }

                // Write the filtered messages
                $writer['object']->write($filtered);
            }
        }
    }

}
