<?php

namespace KORD\Validation;

use KORD\Validation\Exception;
use KORD\Validation\ISBN;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class ISBNSrc extends RuleAbstract
{

    const AUTO = 'auto';
    const ISBN10 = '10';
    const ISBN13 = '13';

    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'type' => ISBN::AUTO,
        'separator' => ''
    ];

    /**
     * Set separator characters.
     *
     * It is allowed only empty string, hyphen and space.
     *
     * @param  string $separator
     * @throws Exception When $separator is not valid
     * @return $this Provides a fluent interface
     */
    public function setSeparator($separator)
    {
        // check separator
        if (!in_array($separator, ['-', ' ', ''])) {
            throw new Exception('Invalid ISBN separator.');
        }

        $this->options['separator'] = $separator;
        return $this;
    }

    /**
     * Get separator characters.
     *
     * @return string
     */
    public function getSeparator()
    {
        return $this->options['separator'];
    }

    /**
     * Set allowed ISBN type.
     *
     * @param  string $type
     * @throws Exception When $type is not valid
     * @return $this Provides a fluent interface
     */
    public function setType($type)
    {
        // check type
        if (!in_array($type, [ISBN::AUTO, ISBN::ISBN10, ISBN::ISBN13])) {
            throw new Exception('Invalid ISBN type');
        }

        $this->options['type'] = $type;
        return $this;
    }

    /**
     * Get allowed ISBN type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->options['type'];
    }

    /**
     * Detect input format.
     *
     * @param string $value
     * @return string
     */
    protected function detectFormat($value)
    {
        // prepare separator and pattern list
        $sep = quotemeta($this->getSeparator());
        $patterns = [];
        $lengths = [];
        $type = $this->getType();

        // check for ISBN-10
        if ($type == ISBN::ISBN10 OR $type == ISBN::AUTO) {
            if (empty($sep)) {
                $pattern = '/^[0-9]{9}[0-9X]{1}$/';
                $length = 10;
            } else {
                $pattern = "/^[0-9]{1,7}[{$sep}]{1}[0-9]{1,7}[{$sep}]{1}[0-9]{1,7}[{$sep}]{1}[0-9X]{1}$/";
                $length = 13;
            }

            $patterns[$pattern] = ISBN::ISBN10;
            $lengths[$pattern] = $length;
        }

        // check for ISBN-13
        if ($type == ISBN::ISBN13 OR $type == ISBN::AUTO) {
            if (empty($sep)) {
                $pattern = '/^[0-9]{13}$/';
                $length = 13;
            } else {
                $pattern = "/^[0-9]{1,9}[{$sep}]{1}[0-9]{1,5}[{$sep}]{1}[0-9]{1,9}[{$sep}]{1}[0-9]{1,9}[{$sep}]{1}[0-9]{1}$/";
                $length = 17;
            }

            $patterns[$pattern] = ISBN::ISBN13;
            $lengths[$pattern] = $length;
        }

        // check pattern list
        foreach ($patterns as $pattern => $type) {
            if ((strlen($value) == $lengths[$pattern]) AND preg_match($pattern, $value)) {
                return $type;
            }
        }

        return null;
    }

    /**
     * Returns true if and only if $value is a valid ISBN.
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value) AND !is_int($value)) {
            $this->addError('isbnInvalid');
            return false;
        }

        $value = (string) $value;

        switch ($this->detectFormat($value)) {
            case ISBN::ISBN10:
                // sum
                $isbn10 = str_replace($this->getSeparator(), '', $value);
                $sum = 0;
                for ($i = 0; $i < 9; $i++) {
                    $sum += (10 - $i) * $isbn10{$i};
                }

                // checksum
                $checksum = 11 - ($sum % 11);
                if ($checksum == 11) {
                    $checksum = '0';
                } elseif ($checksum == 10) {
                    $checksum = 'X';
                }
                break;

            case ISBN::ISBN13:
                // sum
                $isbn13 = str_replace($this->getSeparator(), '', $value);
                $sum = 0;
                for ($i = 0; $i < 12; $i++) {
                    if ($i % 2 == 0) {
                        $sum += $isbn13{$i};
                    } else {
                        $sum += 3 * $isbn13{$i};
                    }
                }
                // checksum
                $checksum = 10 - ($sum % 10);
                if ($checksum == 10) {
                    $checksum = '0';
                }
                break;

            default:
                $this->addError('isbnNoIsbn');
                return false;
        }

        // validate
        if (substr($value, -1) != $checksum) {
            $this->addError('isbnNoIsbn');
            return false;
        }
        return true;
    }

}
