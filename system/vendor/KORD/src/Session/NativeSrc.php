<?php

namespace KORD\Session;

use KORD\Helper\Cookie;

/**
 * Native PHP session class.
 *
 * @copyright  (c) 2007–2014 Kohana Team
 */
class NativeSrc extends \KORD\Session
{

    /**
     * @return  string
     */
    public function id()
    {
        return session_id();
    }

    /**
     * @param   string  $id  session id
     * @return  null
     */
    protected function readSession($id = null)
    {
        // Sync up the session cookie with Cookie parameters
        session_set_cookie_params($this->lifetime, Cookie::$path, Cookie::$domain, Cookie::$secure, Cookie::$httponly);

        // Do not allow PHP to send Cache-Control headers
        session_cache_limiter(false);

        // Set the session cookie name
        session_name($this->cookie_name);

        // Start the session
        $status = session_status();
        if ($status == PHP_SESSION_NONE) {
            if ($id) {
                // Set the session id
                session_id($id);
            }
            //There is no active session
            session_start();
        } elseif ($status == PHP_SESSION_DISABLED) {
            //Sessions are not available
            throw new Exception('PHP sessions are disabled');
        } elseif ($status == PHP_SESSION_ACTIVE) {
            //Destroy current and start new one
            session_destroy();
            if ($id) {
                // Set the session id
                session_id($id);
            }
            session_start();
        }

        // Use the $_SESSION global for storing data
        if (!isset($_SESSION['SESSION_DATA'])) {
            $_SESSION['SESSION_DATA'] = [];
        } elseif ($this->encrypted) {
            // Decrypt the data using the default key
            $_SESSION['SESSION_DATA'] = $this->unserialize(\KORD\Crypt\Encrypt::getInstance($this->encrypted)->decode($_SESSION['SESSION_DATA']));
        }
        $this->data = & $_SESSION['SESSION_DATA'];

        return null;
    }

    /**
     * @return  string
     */
    protected function regenerateSession($delete_old_session = false)
    {
        // Regenerate the session id
        session_regenerate_id($delete_old_session);

        return session_id();
    }

    /**
     * @return  bool
     */
    protected function writeSession()
    {
        if ($this->encrypted) {
            // Encrypt the data using the default key
            $this->data = \KORD\Crypt\Encrypt::getInstance($this->encrypted)->encode($this->serialize($this->data));
        }
        
        // Write and close the session
        session_write_close();

        return true;
    }

    /**
     * @return  bool
     */
    protected function restartSession()
    {
        // Fire up a new session
        $status = session_start();

        // Use the $_SESSION global for storing data
        if (!isset($_SESSION['SESSION_DATA'])) {
            $_SESSION['SESSION_DATA'] = [];
        } elseif ($this->encrypted) {
            // Decrypt the data using the default key
            $_SESSION['SESSION_DATA'] = $this->unserialize(\KORD\Crypt\Encrypt::getInstance($this->encrypted)->decode($_SESSION['SESSION_DATA']));
        }
        $this->data = & $_SESSION['SESSION_DATA'];

        return $status;
    }

    /**
     * @return  bool
     */
    protected function destroySession()
    {
        // Destroy the current session
        session_destroy();

        // Did destruction work?
        $status = !session_id();

        if ($status) {
            // Make sure the session cannot be restarted
            Cookie::delete($this->cookie_name);
        }

        return $status;
    }

}
