<?php

namespace KORD\Validation;

use KORD\Validation\Exception;

class IPSrc extends RuleAbstract
{
    /**
     * Internal options
     *
     * @var array
     */
    protected $options = [
        'allowipv4'      => true, // Enable IPv4 Validation
        'allowipv6'      => true, // Enable IPv6 Validation
        'allowipvfuture' => false, // Enable IPvFuture Validation
        'allowliteral'   => true, // Enable IPs in literal format (only IPv6 and IPvFuture)
    ];

    /**
     * Sets the options for this validator
     *
     * @param array|Traversable $options
     * @throws \KORD\Validation\Exception If there is any kind of IP allowed
     * @return $this
     */
    public function setOptions($options = [])
    {
        parent::setOptions($options);

        if (!$this->options['allowipv4'] AND !$this->options['allowipv6'] AND !$this->options['allowipvfuture']) {
            throw new Exception('Nothing to validate. Check your options');
        }

        return $this;
    }

    /**
     * Returns true if and only if $value is a valid IP address
     *
     * @param  mixed $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('ipInvalid');
            return false;
        }

        if ($this->options['allowipv4'] AND $this->validateIPv4($value)) {
            return true;
        } else {
            if ((bool) $this->options['allowliteral']) {
                static $regex = '/^\[(.*)\]$/';
                if ((bool) preg_match($regex, $value, $matches)) {
                    $value = $matches[1];
                }
            }

            if (($this->options['allowipv6'] AND $this->validateIPv6($value)) OR
                ($this->options['allowipvfuture'] AND $this->validateIPvFuture($value))
            ) {
                return true;
            }
        }
        $this->addError('notIpAddress');
        return false;
    }

    /**
     * Validates an IPv4 address
     *
     * @param string $value
     * @return bool
     */
    protected function validateIPv4($value)
    {
        if (preg_match('/^([01]{8}.){3}[01]{8}\z/i', $value)) {
            // binary format  00000000.00000000.00000000.00000000
            $value = bindec(substr($value, 0, 8)) . '.' . bindec(substr($value, 9, 8)) . '.'
                   . bindec(substr($value, 18, 8)) . '.' . bindec(substr($value, 27, 8));
        } elseif (preg_match('/^([0-9]{3}.){3}[0-9]{3}\z/i', $value)) {
            // octet format 777.777.777.777
            $value = (int) substr($value, 0, 3) . '.' . (int) substr($value, 4, 3) . '.'
                   . (int) substr($value, 8, 3) . '.' . (int) substr($value, 12, 3);
        } elseif (preg_match('/^([0-9a-f]{2}.){3}[0-9a-f]{2}\z/i', $value)) {
            // hex format ff.ff.ff.ff
            $value = hexdec(substr($value, 0, 2)) . '.' . hexdec(substr($value, 3, 2)) . '.'
                   . hexdec(substr($value, 6, 2)) . '.' . hexdec(substr($value, 9, 2));
        }

        $ip2long = ip2long($value);
        if ($ip2long === false) {
            return false;
        }

        return ($value == long2ip($ip2long));
    }

    /**
     * Validates an IPv6 address
     *
     * @param  string $value Value to check against
     * @return bool True when $value is a valid ipv6 address
     *                 False otherwise
     */
    protected function validateIPv6($value)
    {
        if (strlen($value) < 3) {
            return $value == '::';
        }

        if (strpos($value, '.')) {
            $lastcolon = strrpos($value, ':');
            if (!($lastcolon AND $this->validateIPv4(substr($value, $lastcolon + 1)))) {
                return false;
            }

            $value = substr($value, 0, $lastcolon) . ':0:0';
        }

        if (strpos($value, '::') === false) {
            return preg_match('/\A(?:[a-f0-9]{1,4}:){7}[a-f0-9]{1,4}\z/i', $value);
        }

        $colon_count = substr_count($value, ':');
        if ($colon_count < 8) {
            return preg_match('/\A(?::|(?:[a-f0-9]{1,4}:)+):(?:(?:[a-f0-9]{1,4}:)*[a-f0-9]{1,4})?\z/i', $value);
        }

        // special case with ending or starting double colon
        if ($colon_count == 8) {
            return preg_match('/\A(?:::)?(?:[a-f0-9]{1,4}:){6}[a-f0-9]{1,4}(?:::)?\z/i', $value);
        }

        return false;
    }

    /**
     * Validates an IPvFuture address.
     *
     * IPvFuture is loosely defined in the Section 3.2.2 of RFC 3986
     *
     * @param  string $value Value to check against
     * @return bool True when $value is a valid IPvFuture address
     *                 False otherwise
     */
    protected function validateIPvFuture($value)
    {
        /*
         * ABNF:
         * IPvFuture  = "v" 1*HEXDIG "." 1*( unreserved / sub-delims / ":" )
         * unreserved    = ALPHA / DIGIT / "-" / "." / "_" / "~"
         * sub-delims    = "!" / "$" / "&" / "'" / "(" / ")" / "*" / "+" / ","
         *               / ";" / "="
         */
        static $regex = '/^v([[:xdigit:]]+)\.[[:alnum:]\-\._~!\$&\'\(\)\*\+,;=:]+$/';

        $result = (bool) preg_match($regex, $value, $matches);

        /*
         * "As such, implementations must not provide the version flag for the
         *  existing IPv4 and IPv6 literal address forms described below."
         */
        return ($result AND $matches[1] != 4 AND $matches[1] != 6);
    }
}
