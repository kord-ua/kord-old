<?php

namespace KORD\Helper;

/**
 * Random values generator
 * 
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
class RandomSrc
{

    /**
     * Generate random bytes using OpenSSL or Mcrypt
     *
     * @param  int $length
     * @return string
     * @throws RuntimeException
     */
    public static function bytes($length)
    {
        $length = (int) $length;

        if ($length <= 0) {
            return false;
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            return openssl_random_pseudo_bytes($length);
        }

        if (function_exists('mcrypt_create_iv')) {
            $bytes = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if ($bytes !== false AND strlen($bytes) === $length) {
                return $bytes;
            }
        }

        throw new \RuntimeException("PHP environment doesn't support secure random number generation.");
    }
    
    /**
     * Generate random boolean
     *
     * @return bool
     */
    public static function boolean()
    {
        $byte = Random::bytes(1);
        return (bool) (ord($byte) % 2);
    }
    
    /**
     * Generate a random integer between $min and $max
     *
     * @param  int $min
     * @param  int $max
     * @return int
     * @throws InvalidArgumentException
     */
    public static function integer($min, $max)
    {
        if ($min > $max) {
            throw new \InvalidArgumentException(
                'The min parameter must be lower than max parameter'
            );
        }
        $range = $max - $min;
        if ($range == 0) {
            return $max;
        } elseif ($range > PHP_INT_MAX OR is_float($range)) {
            throw new \InvalidArgumentException(
                'The supplied range is too great to generate'
            );
        }

        // calculate number of bits required to store range on this machine
        $r = $range;
        $bits = 0;
        while ($r >>= 1) {
            $bits++;
        }

        $bits   = (int) max($bits, 1);
        $bytes  = (int) max(ceil($bits / 8), 1);
        $filter = (int) ((1 << $bits) - 1);

        do {
            $rnd  = hexdec(bin2hex(Random::bytes($bytes)));
            $rnd &= $filter;
        } while ($rnd > $range);

        return ($min + $rnd);
    }

    /**
     * Generate random float (0..1)
     * This function generates floats with platform-dependent precision
     *
     * PHP uses double precision floating-point format (64-bit) which has
     * 52-bits of significand precision. We gather 7 bytes of random data,
     * and we fix the exponent to the bias (1023). In this way we generate
     * a float of 1.mantissa.
     *
     * @return float
     */
    public static function float()
    {
        $bytes    = Random::bytes(7);
        $bytes[6] = $bytes[6] | chr(0xF0);
        $bytes   .= chr(63); // exponent bias (1023)
        list(, $float) = unpack('d', $bytes);

        return ($float - 1);
    }

    
    /**
     * Generate a random string of specified length.
     *
     * Uses supplied character list for generating the new string.
     *
     * @param  int $length
     * @param  string|null $charlist
     * @return string
     */
    public static function text($length, $charlist = null)
    {
        if ($length <= 0) {
            return false;
        }
        
        if ($charlist === null) {
            // Default is to generate an alphanumeric string
            $charlist = 'alnum';
        }

        switch ($charlist) {
            case 'alnum':
                $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alpha':
                $charlist = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'hexdec':
                $charlist = '0123456789abcdef';
                break;
            case 'numeric':
                $charlist = '0123456789';
                break;
            case 'nozero':
                $charlist = '123456789';
                break;
            case 'distinct':
                $charlist = '2345679ACDEFHJKLMNPRSTUVWXYZ';
                break;
            default:
                $charlist = (string) $charlist;
                break;
        }


        $bytes = Random::bytes($length);
        $pos = 0;
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = ($pos + ord($bytes[$i])) % strlen($charlist);
            $result .= $charlist[$pos];
        }

        return $result;
    }

}
