<?php

namespace KORD\Log;

use KORD\Helper\Date;
use KORD\Log\Level as LogLevel;
use KORD\Log\Writer as LogWriter;

/**
 * Log writer abstract class. All [Log] writers must extend this class.
 *
 * @copyright  (c) 2007–2014 Kohana Team
 */
abstract class WriterSrc
{

    /**
     * @var  string  timestamp format for log entries.
     *
     * Defaults to Date::$timestamp_format
     */
    public static $timestamp;

    /**
     * @var  string  timezone for log entries
     *
     * Defaults to Date::$timezone, which defaults to date_default_timezone_get()
     */
    public static $timezone;

    /**
     * @var  int  Level to use for stack traces
     */
    public static $strace_level = LogLevel::DEBUG;

    /**
     * Write an array of messages.
     *
     *     $writer->write($messages);
     *
     * @param   array   $messages
     * @return  void
     */
    abstract public function write(array $messages);

    /**
     * Allows the writer to have a unique key when stored.
     *
     *     echo $writer;
     *
     * @return  string
     */
    final public function __toString()
    {
        return spl_object_hash($this);
    }

    /**
     * Formats a log entry.
     *
     * @param   array   $message
     * @param   string  $format
     * @return  string
     */
    public function formatMessage(array $message, $format = "time --- level: body in file:line")
    {
        $message['time'] = Date::formattedTime('@' . $message['time'], LogWriter::$timestamp, LogWriter::$timezone, true);
        $message['level'] = strtoupper($message['level']);

        $string = strtr($format, array_filter($message, 'is_scalar'));

        if (isset($message['additional']['exception'])) {
            // Re-use as much as possible, just resetting the body to the trace
            $message['body'] = $message['additional']['exception']->getTraceAsString();
            $message['level'] = strtoupper(LogWriter::$strace_level);

            $string .= PHP_EOL . strtr($format, array_filter($message, 'is_scalar'));
        }

        return $string;
    }

}
