<?php

namespace KORD\Log;

use KORD\Log\Level as LogLevel;

/**
 * @copyright  (c) 2014 Andriy Strepetov
 */
class LevelSrc extends \Psr\Log\LogLevel
{

    /**
     * @var  array  list of supported log levels
     */
    public static $levels = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG
    ];

}
