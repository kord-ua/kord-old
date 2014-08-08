<?php

namespace KORD\Validation;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class EmailSrc extends RuleAbstract
{
    
    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var string
     */
    protected $local_part;

    /**
     * Returns the found mx record informations
     *
     * @var array
     */
    protected $mx_record;

    /**
     * Internal options array
     */
    protected $options = [
        'mx_check' => false,
        'deep_mx_check' => false,
        'domain_check' => true,
        'hostname_validator' => null
    ];

    /**
     * Whether MX checking via getmxrr is supported or not
     *
     * @return bool
     */
    public function isMxSupported()
    {
        return function_exists('getmxrr');
    }

    /**
     * Returns the set mx_check option
     *
     * @return bool
     */
    public function getMxCheck()
    {
        return $this->options['mx_check'];
    }

    /**
     * Set whether we check for a valid MX record via DNS
     *
     * This only applies when DNS hostnames are validated
     *
     * @param  bool $flag Set allowed to true to validate for MX records, and false to not validate them
     * @return $this Fluid Interface
     */
    public function useMxCheck($flag)
    {
        $this->options['mx_check'] = (bool) $flag;
        return $this;
    }

    /**
     * Returns the set deep_mx_check option
     *
     * @return bool
     */
    public function getDeepMxCheck()
    {
        return $this->options['deep_mx_check'];
    }

    /**
     * Use deep validation for MX records
     *
     * @param  bool $flag Set deep to true to perform a deep validation process for MX records
     * @return $this Fluid Interface
     */
    public function useDeepMxCheck($flag)
    {
        $this->options['deep_mx_check'] = (bool) $flag;
        return $this;
    }
    
    /**
     * Returns the set domain_check option
     *
     * @return bool
     */
    public function getDomainCheck()
    {
        return $this->options['domain_check'];
    }

    /**
     * Sets if the domain should also be checked
     * or only the local part of the email address
     *
     * @param  bool $flag
     * @return $this Fluid Interface
     */
    public function useDomainCheck($flag)
    {
        $this->options['domain_check'] = (bool) $flag;
        return $this;
    }
    
    /**
     * Returns the set hostname validator
     *
     * If was not previously set then lazy load a new one
     *
     * @return Hostname
     */
    public function getHostnameValidator()
    {
        if (!isset($this->options['hostname_validator'])) {
            $this->options['hostname_validator'] = new Hostname();
        }

        return $this->options['hostname_validator'];
    }

    /**
     * @param Hostname $hostname_validator
     * @return $this Provides a fluent interface
     */
    public function setHostnameValidator(Hostname $hostname_validator)
    {
        $this->options['hostname_validator'] = $hostname_validator;

        return $this;
    }

    /**
     * Returns if the given host is reserved
     *
     * The following addresses are seen as reserved
     * '0.0.0.0/8', '10.0.0.0/8', '127.0.0.0/8'
     * '100.64.0.0/10'
     * '172.16.0.0/12'
     * '198.18.0.0/15'
     * '169.254.0.0/16', '192.168.0.0/16'
     * '192.0.2.0/24', '192.88.99.0/24', '198.51.100.0/24', '203.0.113.0/24'
     * '224.0.0.0/4', '240.0.0.0/4'
     * @see http://en.wikipedia.org/wiki/Reserved_IP_addresses
     *
     * As of RFC5753 (JAN 2010), the following blocks are no longer reserved:
     *   - 128.0.0.0/16
     *   - 191.255.0.0/16
     *   - 223.255.255.0/24
     * @see http://tools.ietf.org/html/rfc5735#page-6
     *
     * As of RFC6598 (APR 2012), the following blocks are now reserved:
     *   - 100.64.0.0/10
     * @see http://tools.ietf.org/html/rfc6598#section-7
     *
     * @param string $host
     * @return bool Returns false when minimal one of the given addresses is not reserved
     */
    protected function isReserved($host)
    {
        if (!preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $host)) {
            $host = gethostbynamel($host);
        } else {
            $host = [$host];
        }

        if (empty($host)) {
            return false;
        }

        foreach ($host as $server) {
            // Search for 0.0.0.0/8, 10.0.0.0/8, 127.0.0.0/8
            if (!preg_match('/^(0|10|127)(\.([0-9]|[1-9][0-9]|1([0-9][0-9])|2([0-4][0-9]|5[0-5]))){3}$/', $server) AND
                    // Search for 100.64.0.0/10
                    !preg_match('/^100\.(6[0-4]|[7-9][0-9]|1[0-1][0-9]|12[0-7])(\.([0-9]|[1-9][0-9]|1([0-9][0-9])|2([0-4][0-9]|5[0-5]))){2}$/', $server) AND
                    // Search for 172.16.0.0/12
                    !preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])(\.([0-9]|[1-9][0-9]|1([0-9][0-9])|2([0-4][0-9]|5[0-5]))){2}$/', $server) AND
                    // Search for 198.18.0.0/15
                    !preg_match('/^198\.(1[8-9])(\.([0-9]|[1-9][0-9]|1([0-9][0-9])|2([0-4][0-9]|5[0-5]))){2}$/', $server) AND
                    // Search for 169.254.0.0/16, 192.168.0.0/16
                    !preg_match('/^(169\.254|192\.168)(\.([0-9]|[1-9][0-9]|1([0-9][0-9])|2([0-4][0-9]|5[0-5]))){2}$/', $server) AND
                    // Search for 192.0.2.0/24, 192.88.99.0/24, 198.51.100.0/24, 203.0.113.0/24
                    !preg_match('/^(192\.0\.2|192\.88\.99|198\.51\.100|203\.0\.113)\.([0-9]|[1-9][0-9]|1([0-9][0-9])|2([0-4][0-9]|5[0-5]))$/', $server) AND
                    // Search for 224.0.0.0/4, 240.0.0.0/4
                    !preg_match('/^(2(2[4-9]|[3-4][0-9]|5[0-5]))(\.([0-9]|[1-9][0-9]|1([0-9][0-9])|2([0-4][0-9]|5[0-5]))){3}$/', $server)
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Internal method to validate the local part of the email address
     *
     * @return bool
     */
    protected function validateLocalPart()
    {
        // First try to match the local part on the common dot-atom format
        $result = false;

        // Dot-atom characters are: 1*atext *("." 1*atext)
        // atext: ALPHA / DIGIT / and "!", "#", "$", "%", "&", "'", "*",
        //        "+", "-", "/", "=", "?", "^", "_", "`", "{", "|", "}", "~"
        $atext = 'a-zA-Z0-9\x21\x23\x24\x25\x26\x27\x2a\x2b\x2d\x2f\x3d\x3f\x5e\x5f\x60\x7b\x7c\x7d\x7e';
        if (preg_match('/^[' . $atext . ']+(\x2e+[' . $atext . ']+)*$/', $this->local_part)) {
            $result = true;
        } else {
            // Try quoted string format (RFC 5321 Chapter 4.1.2)
            // Quoted-string characters are: DQUOTE *(qtext/quoted-pair) DQUOTE
            $qtext = '\x20-\x21\x23-\x5b\x5d-\x7e'; // %d32-33 / %d35-91 / %d93-126
            $quoted_pair = '\x20-\x7e'; // %d92 %d32-126
            if (preg_match('/^"([' . $qtext . ']|\x5c[' . $quoted_pair . '])*"$/', $this->local_part)) {
                $result = true;
            } else {
                $this->addError('emailDotAtom', [':localpart' => $this->local_part]);
                $this->addError('emailQuotedString', [':localpart' => $this->local_part]);
                $this->addError('emailInvalidLocalPart', [':localpart' => $this->local_part]);
            }
        }

        return $result;
    }

    /**
     * Returns the found MX Record information after validation including weight for further processing
     *
     * @return array
     */
    public function getMXRecord()
    {
        return $this->mx_record;
    }

    /**
     * Internal method to validate the servers MX records
     *
     * @return bool
     */
    protected function validateMXRecords()
    {
        $mx_hosts = [];
        $weight = [];
        $result = getmxrr($this->hostname, $mx_hosts, $weight);
        if (!empty($mx_hosts) AND !empty($weight)) {
            $this->mx_record = array_combine($mx_hosts, $weight);
        } else {
            $this->mx_record = $mx_hosts;
        }

        arsort($this->mx_record);

        // Fallback to IPv4 hosts if no MX record found (RFC 2821 SS 5).
        if (!$result) {
            $result = gethostbynamel($this->hostname);
            if (is_array($result)) {
                $this->mx_record = array_flip($result);
            }
        }

        if (!$result) {
            $this->addError('emailInvalidMxRecord', [':hostname' => $this->hostname]);
            return $result;
        }

        if (!$this->getDeepMxCheck()) {
            return $result;
        }

        $valid_address = false;
        $reserved = true;
        foreach ($this->mx_record as $hostname => $weight) {
            $res = $this->isReserved($hostname);
            if (!$res) {
                $reserved = false;
            }

            if (!$res AND (checkdnsrr($hostname, "A") OR checkdnsrr($hostname, "AAAA") OR checkdnsrr($hostname, "A6"))
            ) {
                $valid_address = true;
                break;
            }
        }

        if (!$valid_address) {
            $result = false;
            $error = ($reserved) ? 'emailInvalidSegment' : 'emailInvalidMxRecord';
            $this->addError($error, [':hostname' => $this->hostname]);
        }

        return $result;
    }

    /**
     * Internal method to validate the hostname part of the email address
     *
     * @return bool
     */
    protected function validateHostnamePart()
    {
        $hostname = $this->getHostnameValidator()->isValid($this->hostname);
        if (!$hostname) {
            $this->addError('emailInvalidHostname', [':hostname' => $this->hostname]);
        } elseif ($this->getMxCheck()) {
            // MX check on hostname
            $hostname = $this->validateMXRecords();
        }

        return $hostname;
    }

    /**
     * Splits the given value in hostname and local part of the email address
     *
     * @param string $value Email address to be split
     * @return bool Returns false when the email can not be split
     */
    protected function splitEmailParts($value)
    {
        // Split email address up and disallow '..'
        if ((strpos($value, '..') !== false) or ( !preg_match('/^(.+)@([^@]+)$/', $value, $matches))) {
            return false;
        }

        $this->local_part = $matches[1];
        $this->hostname = $matches[2];

        return true;
    }

    /**
     * Defined by \KORD\Validation\RuleInterface
     *
     * Returns true if and only if $value is a valid email address
     * according to RFC2822
     *
     * @link   http://www.ietf.org/rfc/rfc2822.txt RFC2822
     * @link   http://www.columbia.edu/kermit/ascii.html US-ASCII characters
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('emailInvalid');
            return false;
        }

        $length = true;

        // Split email address up and disallow '..'
        if (!$this->splitEmailParts($value)) {
            $this->addError('emailInvalidFormat');
            return false;
        }

        if ((strlen($this->local_part) > 64) OR (strlen($this->hostname) > 255)) {
            $length = false;
            $this->addError('emailLengthExceeded');
        }

        // Match hostname part
        if ($this->getDomainCheck()) {
            $hostname = $this->validateHostnamePart();
        }

        $local = $this->validateLocalPart();

        // If both parts valid, return true
        if ($local AND $length) {
            if (($this->getDomainCheck() AND $hostname) OR !$this->getDomainCheck()) {
                return true;
            }
        }

        return false;
    }

}
