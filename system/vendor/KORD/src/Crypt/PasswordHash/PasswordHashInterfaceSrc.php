<?php

namespace KORD\Crypt\PasswordHash;

/**
 * @copyright  (c) 2014 Andriy Strepetov
 */
interface PasswordHashInterfaceSrc
{

    /**
     * Create a password hash for a given password
     *
     * @param  string $password The password to hash
     * @return string
     */
    public function create($password);

    /**
     * Verify a password hash against a given password
     *
     * @param  string $password The password to hash
     * @param  string $hash     The supplied hash to validate
     * @return bool
     */
    public function validate($password, $hash);
    
}
