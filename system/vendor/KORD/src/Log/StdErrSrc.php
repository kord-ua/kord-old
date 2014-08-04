<?php

/**
 * STDERR log writer. Writes out messages to STDERR.
 *
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD\Log;

class StdErrSrc extends \KORD\Log\Writer
{

    /**
     * Writes each of the messages to STDERR.
     *
     *     $writer->write($messages);
     *
     * @param   array   $messages
     * @return  void
     */
    public function write(array $messages)
    {
        foreach ($messages as $message) {
            // Writes out each message
            fwrite(STDERR, $this->formatMessage($message) . PHP_EOL);
        }
    }

}
