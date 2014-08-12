<?php

namespace KORD\Crypt\PasswordHash;

use KORD\Helper\Random;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class BcryptSrc implements PasswordHashInterface
{

    protected $config = [
        'cost' => '10',
        'salt' => null,
        'back_compat' => false
    ];

    public function __construct($config)
    {
        if (!defined('CRYPT_BLOWFISH') OR ! CRYPT_BLOWFISH) {
            throw new \DomainException('This server does not support bcrypt blowfish algorithm hashing');
        }

        $this->config = $config + $this->config;

        if (!empty($this->config['cost'])) {
            $cost = (int) $this->config['cost'];
            if ($cost < 4 OR $cost > 31) {
                throw new \InvalidArgumentException(
                'The cost parameter of bcrypt must be in range 04-31'
                );
            }
            $this->config['cost'] = sprintf('%1$02d', $cost);
        }

        if (!$this->config['salt']) {
            $this->config['salt'] = Random::text(22, 'alnum');
        }
    }

    /**
     * Create a password hash for a given password
     *
     * @param  string $password The password to hash
     * @return string
     */
    public function create($password)
    {
        /**
         * Check for security flaw in the bcrypt implementation used by crypt()
         * @see http://php.net/security/crypt_blowfish.php
         */
        if ((PHP_VERSION_ID >= 50307) AND !$this->config['back_compat']) {
            $prefix = '$2y$';
        } else {
            $prefix = '$2a$';
            // check if the password contains 8-bit character
            if (preg_match('/[\x80-\xFF]/', $password)) {
                throw new \RuntimeException('Passwords should contain only 7-bit characters');
            }
        }
        $hash = crypt($password, $prefix . $this->config['cost'] . '$' . $this->config['salt']);
        if (strlen($hash) < 13) {
            throw new \RuntimeException('Error during the bcrypt generation');
        }
        return $hash;
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
        $result = crypt($password, $hash);
        if ($result === $hash) {
            return true;
        }
        return false;
    }

}
