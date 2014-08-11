<?php

namespace KORD\Log;

use KORD\Log\Writer as LogWriter;

/**
 * Syslog log writer.
 *
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
class SyslogSrc extends LogWriter
{

    /**
     * @var  string  The syslog identifier
     */
    protected $ident;

    /**
     * Creates a new syslog logger.
     *
     * @link    http://www.php.net/manual/function.openlog
     *
     * @param   string  $ident      syslog identifier
     * @param   int     $facility   facility to log to
     * @return  void
     */
    public function __construct($ident = 'KORDPHP', $facility = LOG_USER)
    {
        $this->ident = $ident;

        // Open the connection to syslog
        openlog($this->ident, LOG_CONS, $facility);
    }

    /**
     * Writes each of the messages into the syslog.
     *
     * @param   array   $messages
     * @return  void
     */
    public function write(array $messages)
    {
        foreach ($messages as $message) {
            syslog($message['level'], $message['body']);

            if (isset($message['additional']['exception'])) {
                syslog(LogWriter::$strace_level, $message['additional']['exception']->getTraceAsString());
            }
        }
    }

    /**
     * Closes the syslog connection
     *
     * @return  void
     */
    public function __destruct()
    {
        // Close connection to syslog
        closelog();
    }

}
