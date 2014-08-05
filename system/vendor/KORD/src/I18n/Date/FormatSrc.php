<?php

/**
 * I18n Date Format class
 * 
 * Provides date formatting and translation methods to achieve consistency with MooTools `Date.format()`
 * `Format::format()` based on MooTools `Date.format()`
 * 
 * @see  http://github.com/mootools/mootools-more/blob/1.3wip/Source/Types/Date.js#L164
 * 
 * @copyright  (c) 2012 Korney Czukowski
 */

namespace KORD\I18n\Date;

class FormatSrc
{

    /**
     * @var  array  Named formats
     */
    protected $formats = [
        'db' => '%Y-%m-%d %H:%M:%S',
        'compact' => '%Y%m%dT%H%M%S',
        'header' => '%g',
        'iso8601' => '%Y-%m-%dT%H:%M:%S%P',
        'rfc822' => '%r',
        'rfc2822' => '%r',
        // 04 Oct 07:25
        'short' => '%d %b %H:%M',
        // October 04, 2011 07:41
        'long' => '%B %d, %Y %H:%M',
        // 4 October 2011 07:51
        // TODO: this is local date format, remove or merged under auto-local formatting
        'article' => '%e %C %Y %H:%M',
    ];

    /**
     * @var  integer
     */
    protected $timestamp = 0;

    /**
     * @param  mixed  $time
     */
    public function __construct($time)
    {
        if (is_int($time)) {
            $this->timestamp = $time;
        } elseif (is_string($time)) {
            $this->timestamp = strtotime($time);
        } else {
            throw new \InvalidArgumentException('Unsupported time format');
        }
    }

    /**
     * Formats time
     * 
     * @param  string  $format
     */
    public function format($format = null)
    {
        if ($format === null) {
            $format = '%x %X';
        }
        // Replace short-hand with actual format
        if (array_key_exists($format, $this->formats)) {
            $format = $this->formats[$format];
        }
        return preg_replace_callback('#%([a-z%])#i', [$this, 'replaceFormat'], $format);
    }

    /**
     * Callback to replace format
     */
    protected function replaceFormat($match)
    {
        switch ($match[1]) {
            case 'a':  // Short day ("Mon", "Tue")
                return $this->getItem(date('w', $this->timestamp), 'days', 'abbr');
            case 'A':  // Full day ("Monday")
                return $this->getItem(date('w', $this->timestamp), 'days');
            case 'b':  // Short month ("Jan", "Feb")
                return $this->getItem(date('n', $this->timestamp) - 1, 'months', 'abbr');
            case 'B':  // Full month ("January")
                return $this->getItem(date('n', $this->timestamp) - 1, 'months', 'other');
            case 'c':  // The full date to string "Mon Dec 10 2007 14:35:42 GMT-0800 (Pacific Standard Time)"
                return $this->format('%a %b %d %H:%m:%S %Y');
            case 'C':  // Full month in the genitive case (e.g. 'Январь' -> 'Января')
                // Non-compliant with MooTools Date.format()
                return $this->getItem(date('n', $this->timestamp) - 1, 'months', 'gen');
            case 'd':  // The date to two digits (01, 05, etc)
                return date('d', $this->timestamp);
            case 'D':  // 3-letter, non-localized textual representation of a day (Mon, Tue)
                // Non-compliant with MooTools Date.format()
                return date('D', $this->timestamp);
            case 'e':  // Day of the month without leading zeros
                return str_pad(date('j', $this->timestamp), 2, ' ', STR_PAD_LEFT);
            case 'g':  // Time format usable in HTTP headers
                // Non-compliant with MooTools Date.format()
                return gmdate('D, d M Y H:i:s', $this->timestamp) . ' GMT';
            case 'H':  // The hour to two digits in military time (24 hr mode) (01, 11, 14, etc)
                return date('H', $this->timestamp);
            case 'I':  // The hour in 12 hour time (1, 11, 2, etc)
                // Note that for 00:xx:xx the 12hr format is 12:xx (am)
                return date('g', $this->timestamp);
            case 'j':  // The day of the year to three digits (001 is Jan 1st)
                return str_pad(date('z', $this->timestamp), 3, '0', STR_PAD_LEFT);
            case 'k':  // The hour (24-hour clock) as a digit (range 0 to 23).
                // Single digits are preceded by a blank space.
                return str_pad(date('G', $this->timestamp), 2, ' ', STR_PAD_LEFT);
            case 'l':  // The hour (12-hour clock) as a digit (range 1 to 12).
                // Single digits are preceded by a blank space.
                return str_pad(date('g', $this->timestamp), 2, ' ', STR_PAD_LEFT);
            case 'L':  // Milliseconds (timestamp donesn't have milliseconds)
                return '000';
            case 'm':  // The numerical month to two digits (01 is Jan, 12 is Dec)
                return date('m', $this->timestamp);
            case 'M':  // The minutes to two digits (01, 40, 59)
                return date('i', $this->timestamp);
            case 'N':  // Localized accusative case of week day name
                // Non-compliant with MooTools Date.format()
                return $this->getItem(date('w', $this->timestamp), 'days', 'acc');
            case 'o':  // Non-local. The ordinal of the day of the month
                // ("st" for the 1st, "nd" for the 2nd, etc.)
                return date('jS', $this->timestamp);
            case 'p':  // The current language equivalent of either AM or PM
                return __('date.' . (date('G', $this->timestamp) < 12 ? 'am' : 'pm'));
            case 'P':  // The GMT offset ("-08:00")
                // Non-compliant with MooTools Date.format()
                return date('P', $this->timestamp);
            case 'r':  // Added to workaround localization of RFC2822 date format
                return date('r', $this->timestamp);
            case 's':
                return $this->timestamp;
            case 'S':  // The seconds to two digits (01, 40, 59)
                return date('s', $this->timestamp);
            case 'U':  // The week to two digits (01 is the week of Jan 1, 52 is the week of Dec 31)
                return date('W', $this->timestamp);
            case 'w':  // The numerical day of the week, one digit (0 is Sunday, 1 is Monday)
                return date('w', $this->timestamp);
            case 'x':  // The date in the current language prefered format. en-US: %m/%d/%Y (12/10/2007)
                return $this->format(__('date.date.short'));
            case 'X':  // The time in the current language prefered format. en-US: %I:%M%p (02:45PM)
                return $this->format(__('date.time.short'));
            case 'y':  // The short year (two digits; "07")
                return date('y', $this->timestamp);
            case 'Y':  // The full year (four digits; "2007")
                return date('Y', $this->timestamp);
            case 'z':  // The GMT offset ("-0800")
                return date('O', $this->timestamp);
            case 'Z':  // The time zone ("GMT")
                return date('T', $this->timestamp);
            case '%':
                return '%';
        }
    }

    /**
     * @param  integer  $index
     * @param  string   $path
     * @param  string   $form
     */
    protected function getItem($index, $path, $form = null)
    {
        $string = __('date.' . $path, $form);
        return $string[$index];
    }

}
