<?php

namespace KORD\Crypt\PasswordHash;

use KORD\Crypt\Hash;

/**
 * @copyright  (c) 2014 Andriy Strepetov
 */
class HashSrc
{

    protected $config = [
        'hash_instance' => null,
    ];

    public function __construct($config)
    {
        $this->config = $config + $this->config;
        
        if (empty(Hash::getInstance($this->config['hash_instance'])->key)) {
            throw new \InvalidArgumentException('The Hash instance key should be not empty');
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
        return Hash::getInstance($this->config['hash_instance'])->compute($password);
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
        $result = Hash::getInstance($this->config['hash_instance'])->compute($password);
        return ($result === $hash);
    }

}
