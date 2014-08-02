<?php

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
