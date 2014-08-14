<?php

namespace KORD\Security;

use KORD\Helper\Random;
use KORD\Session;

class CSRFSrc
{

    /**
     * @var  string  session key name used for csrf token storage
     */
    protected static $tokens_key = 'csrf_tokens';

    /**
     * Generate and store a unique token which can be used to help prevent
     * [CSRF](http://wikipedia.org/wiki/Cross_Site_Request_Forgery) attacks.
     * 
     * Returns a new token
     * 
     *      $token = CSRF::newToken();
     * 
     * @return string  csrf token
     */
    public static function newToken()
    {
        // Get tokens
        $tokens = Session::getInstance()->get(CSRF::$tokens_key);
        
        if (!$tokens) {
            $tokens = [];
        }

        // Generate a new unique token
        $tokens[] = $token = base64_encode(Random::bytes(32));

        // Store the new token
        Session::getInstance()->set(CSRF::$tokens_key, $tokens);

        return $token;
    }

    /**
     * Check that the given value matches the currently stored security token.
     * 
     * @return bool  true if matches, false if not
     */
    public static function checkToken($token)
    {
        // Get tokens
        $tokens = Session::getInstance()->get(CSRF::$tokens_key);
        
        return in_array($token, $tokens);
    }
    
    /**
     * Delete CSRF token
     */
    public static function deleteToken($token)
    {
        // Get tokens
        $tokens = Session::getInstance()->get(CSRF::$tokens_key);
        
        // Unset token
        if ($tokens) {
            $tokens = array_diff($tokens, [$token]);
        }
        
        // Save changes
        Session::getInstance()->set(CSRF::$tokens_key, $tokens);
    }

    /**
     * Delete all CSRF tokens
     */
    public static function clearTokens()
    {
        Session::getInstance()->delete(CSRF::$tokens_key);
    }

}
