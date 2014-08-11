<?php

namespace KORD\I18n;

use KORD\I18n\Date\Format as DateFormat;

/**
 * I18n Date helper.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2012 Korney Czukowski
 * @copyright  (c) 2014 Andriy Strepetov
 * @license    MIT License
 */
class DateSrc
{

    /**
     * Returns the difference between a time and now in a "fuzzy" way.
     * Displaying a fuzzy time instead of a date is usually faster to read and understand.
     *
     *     $span = Date::fuzzySpan(time() - 10); //less than a minute ago
     * 
     *     $span = Date::fuzzySpan(time(), time() + 86400); //1 day ago 
     *
     * A second parameter is available to manually set the "local" timestamp,
     * however this parameter shouldn't be needed in normal usage and is only
     * included for unit tests
     *
     * @param   integer  $from  UNIX timestamp
     * @param   integer  $to  UNIX timestamp, current timestamp is used when null
     * @return  string
     */
    public static function fuzzySpan($from, $to = null)
    {
        if (!$from) {
            return __('date.never');
        }
        if ($to === null) {
            $to = time();
        }
        return Date::getTimePhrase($to - $from);
    }

    /**
     * Returns verbose time interval based on time difference
     * 
     * @staticvar  array    $units
     * @param      integer  $delta  time difference in seconds
     * @return     string
     */
    public static function getTimePhrase($delta)
    {
        $suffix = ($delta < 0) ? '_until' : '_ago';
        if ($delta < 0) {
            $delta *= -1;
        }

        static $units = [
            'minute' => 60,
            'hour' => 60,
            'day' => 24,
            'week' => 7,
            'month' => 4.333333,
            'year' => 12,
            'eon' => INF,
        ];

        $msg = 'less_than_minute';
        foreach ($units as $unit => $interval) {
            if ($delta < 1.5 * $interval) {
                if ($delta > 0.75 * $interval) {
                    $msg = $unit;
                    $delta /= $interval;
                }
                break;
            }
            $delta /= $interval;
            $msg = $unit;
        }
        $delta = (int) round($delta);

        return __('date.' . $msg . $suffix, $delta, array('{delta}' => $delta));
    }

    /**
     * Formats date and time.
     * 
     * @param   mixed   $timestamp  integer, string date representation, \KORD\I18n\Date\Format object or NULL
     * @param   string  $format  format string or shorthand, '%x %X' if NULL
     * @return  string
     */
    public static function format($timestamp = null, $format = null)
    {
        if ($timestamp === null) {
            $timestamp = time();
        }
        $time = new DateFormat($timestamp);
        return $time->format($format);
    }

}
