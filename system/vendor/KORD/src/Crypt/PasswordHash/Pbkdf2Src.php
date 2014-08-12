<?php

/*
 * Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
 * Copyright (c) 2013, Taylor Hornby
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, 
 * this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation 
 * and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace KORD\Crypt\PasswordHash;

/**
 * Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
 * Allows to create secure salted password hashes, persistent to timing
 * attacks.
 * 
 * Uses [Mcrypt](http://php.net/mcrypt) extension to create random salt
 * 
 * @copyright  (c) 2013 Taylor Hornby
 * @copyright  (c) 2014 Andriy Strepetov
 */
class Pbkdf2Src implements PasswordHashInterface
{
    
    protected $config = [
        'hash_algorithm' => 'sha256',
        'iterations' => 1000,
        'salt_byte_size' => 32,
        'hash_byte_size' => 32,
        'hash_sections' => 4,
        'hash_algorithm_index' => 0,
        'hash_iteration_index' => 1,
        'hash_salt_index' => 2,
        'hash_pbkdf2_index' => 3
    ];
    
    public function __construct($config)
    {
        $this->config = $config + $this->config;
    }

    /**
     * Create a password hash for a given password
     *
     * @param  string $password The password to hash
     * @return string
     */
    public function create($password)
    {
        // format: algorithm:iterations:salt:hash
        $salt = base64_encode(mcrypt_create_iv($this->config['salt_byte_size'], MCRYPT_DEV_URANDOM));
        return $this->config['hash_algorithm'] . ":" . $this->config['iterations'] . ":" . $salt . ":" .
                base64_encode(
                        $this->pbkdf2(
                                $this->config['hash_algorithm'], 
                                $password, 
                                $salt, 
                                $this->config['iterations'], 
                                $this->config['hash_byte_size'], 
                                true
                        )
        );
    }

    /**
     * Verify a password hash against a given password
     *
     * @param  string $password The password to hash
     * @param  string $hash     The supplied hash to validate
     * @return bool
     */
    public function validate($password, $hash)
    {
        $params = explode(":", $hash);
        if (count($params) < $this->config['hash_sections']) {
            return false;
        }

        $pbkdf2 = base64_decode($params[$this->config['hash_pbkdf2_index']]);
        return $this->slowEquals(
                        $pbkdf2, $this->pbkdf2(
                                $params[$this->config['hash_algorithm_index']], 
                                $password, 
                                $params[$this->config['hash_salt_index']], 
                                (int) $params[$this->config['hash_iteration_index']], 
                                strlen($pbkdf2), 
                                true
                        )
        );
    }

    /**
     * Compares two strings $a and $b in length-constant time. 
     */
    public function slowEquals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);
        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }

    /**
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     * $algorithm - The hash algorithm to use. Recommended: SHA256
     * $password - The password.
     * $salt - A salt that is unique to the password.
     * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
     * $key_length - The length of the derived key in bytes.
     * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
     * Returns: A $key_length-byte key derived from the password and salt.
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     *
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     */
    public function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
    {
        $algorithm = strtolower($algorithm);
        if (!in_array($algorithm, hash_algos(), true)) {
            trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
        }

        if ($count <= 0 || $key_length <= 0) {
            trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);
        }

        if (function_exists("hash_pbkdf2")) {
            // The output length is in NIBBLES (4-bits) if $raw_output is false!
            if (!$raw_output) {
                $key_length = $key_length * 2;
            }
            return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
        }

        $hash_length = strlen(hash($algorithm, "", true));
        $block_count = ceil($key_length / $hash_length);

        $output = "";
        for ($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack("N", $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if ($raw_output) {
            return substr($output, 0, $key_length);
        } else {
            return bin2hex(substr($output, 0, $key_length));
        }
    }

}
