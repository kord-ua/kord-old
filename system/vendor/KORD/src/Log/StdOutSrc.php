<?php

/**
 * STDOUT log writer. Writes out messages to STDOUT.
 *
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD\Log;

class StdOutSrc extends \KORD\Log\Writer
{

    /**
     * Writes each of the messages to STDOUT.
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
            fwrite(STDOUT, $this->formatMessage($message) . PHP_EOL);
        }
    }

}
