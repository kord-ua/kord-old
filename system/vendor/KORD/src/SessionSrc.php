<?php

namespace KORD;

use KORD\Core;
use KORD\Exception;
use KORD\Log\Level;

/**
 * Base session class.
 *
 * @copyright  (c) 2007–2014 Kohana Team
 */
abstract class SessionSrc
{

    /**
     * @var  string  default session adapter
     */
    public static $default = 'native';

    /**
     * @var  array  session instances
     */
    protected static $instances = [];

    /**
     * Sets a new instance of session of the given type. Some session types
     * (native, database) also support restarting a session by passing a
     * session id as the second parameter.
     *
     *     $session = Session::setInstance();
     *
     * [!!] [Session::write] will automatically be called when the request ends.
     *
     * @param   string  $type   type of session (native, cookie, etc)
     * @param   string  $id     session identifier
     * @param   array   $config session instance configuration
     */
    public static function setInstance($type = null, $id = null, $config = [])
    {
        if ($type === null) {
            // Use the default type
            $type = Session::$default;
        }

        $class = '\\KORD\\Session\\' . ucfirst($type);

        // Create a new session instance
        Session::$instances[$type] = $session = new $class($config, $id);

        // Write the session at shutdown
        register_shutdown_function([$session, 'write']);
    }

    /**
     * Returns an instance of Encrypt.
     *
     *     $session = Session::getInstance();
     *
     * @param   string  $type   type of session (native, cookie, etc)
     * @return  Session
     */
    public static function getInstance($type = null)
    {
        if ($type === null) {
            // Use the default type
            $type = Session::$default;
        }

        return Session::$instances[$type];
    }

    /**
     * @var  string  cookie name
     */
    protected $cookie_name = 'session';

    /**
     * @var  int  cookie/session lifetime
     */
    protected $lifetime = 3600;

    /**
     * @var  int  session id (SID) lifetime
     */
    protected $id_lifetime = 60;

    /**
     * @var  bool  encrypt session data?
     */
    protected $encrypted = false;

    /**
     * @var bool  check SID owners' IP address? 
     */
    protected $check_ip = true;

    /**
     * @var bool  check SID owners' User-Agent? 
     */
    protected $check_user_agent = true;

    /**
     * @var  array  session data
     */
    protected $data = [];

    /**
     * @var  bool  session destroyed?
     */
    protected $destroyed = false;

    /**
     * Overloads the cookie_name, lifetime, and encrypted session settings.
     *
     * [!!] Sessions can only be created using the [Session::setInstance] method.
     *
     * @param   array   $config configuration
     * @param   string  $id     session id
     * @return  void
     * @uses    Session::read
     */
    public function __construct(array $config = null, $id = null)
    {
        if (isset($config['cookie_name'])) {
            // Cookie name to store the session id in
            $this->cookie_name = (string) $config['cookie_name'];
        }

        if (isset($config['lifetime'])) {
            // Cookie lifetime
            $this->lifetime = (int) $config['lifetime'];
        }

        if (isset($config['id_lifetime'])) {
            // SID lifetime
            $this->id_lifetime = (int) $config['id_lifetime'];
        }

        if (isset($config['encrypted'])) {
            if ($config['encrypted'] === true) {
                // Use the default Encrypt instance
                $config['encrypted'] = 'default';
            }

            // Enable or disable encryption of data
            $this->encrypted = $config['encrypted'];
        }

        if (isset($config['check_ip'])) {
            // Check the ip address of SID owner
            $this->check_ip = (bool) $config['check_ip'];
        }

        if (isset($config['check_user_agent'])) {
            // Check the User-Agent of SID owner
            $this->check_user_agent = (bool) $config['check_user_agent'];
        }

        // Load the session
        $this->read($id);
    }

    /**
     * Session object is rendered to a serialized string. If encryption is
     * enabled, the session will be encrypted. If not, the output string will
     * be encoded.
     *
     *     echo $session;
     *
     * @return  string
     * @uses    Encrypt::encode
     */
    public function __toString()
    {
        // Serialize the data array
        $data = $this->serialize($this->data);

        if ($this->encrypted) {
            // Encrypt the data using the default key
            $data = \KORD\Crypt\Encrypt::getInstance($this->encrypted)->encode($data);
        } else {
            // Encode the data
            $data = $this->encode($data);
        }

        return $data;
    }

    /**
     * Returns the current session array. The returned array can also be
     * assigned by reference.
     *
     *     // Get a copy of the current session data
     *     $data = $session->asArray();
     *
     *     // Assign by reference for modification
     *     $data =& $session->asArray();
     *
     * @return  array
     */
    public function & asArray()
    {
        return $this->data;
    }

    /**
     * Get the current session id, if the session supports it.
     *
     *     $id = $session->id();
     *
     * [!!] Not all session types have ids.
     *
     * @return  string
     */
    public function id()
    {
        return null;
    }

    /**
     * Get the current session cookie name.
     *
     *     $name = $session->cookieName();
     *
     * @return  string
     */
    public function cookieName()
    {
        return $this->cookie_name;
    }

    /**
     * Get a variable from the session array.
     *
     *     $foo = $session->get('foo');
     *
     * @param   string  $key        variable name
     * @param   mixed   $default    default value to return
     * @return  mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
    }

    /**
     * Get and delete a variable from the session array.
     *
     *     $bar = $session->getOnce('bar');
     *
     * @param   string  $key        variable name
     * @param   mixed   $default    default value to return
     * @return  mixed
     */
    public function getOnce($key, $default = null)
    {
        $value = $this->get($key, $default);

        unset($this->data[$key]);

        return $value;
    }

    /**
     * Set a variable in the session array.
     *
     *     $session->set('foo', 'bar');
     *
     * @param   string  $key    variable name
     * @param   mixed   $value  value
     * @return  $this
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Set a variable by reference.
     *
     *     $session->bind('foo', $foo);
     *
     * @param   string  $key    variable name
     * @param   mixed   $value  referenced value
     * @return  $this
     */
    public function bind($key, & $value)
    {
        $this->data[$key] = & $value;

        return $this;
    }

    /**
     * Removes a variable in the session array.
     *
     *     $session->delete('foo');
     *
     * @param   string  $key    variable name(s)
     * @return  $this
     */
    public function delete($key)
    {
        $args = func_get_args();

        foreach ($args as $key) {
            unset($this->data[$key]);
        }

        return $this;
    }

    /**
     * Loads existing session data.
     *
     *     $session->read();
     *
     * @param   string  $id session id
     * @return  void
     */
    public function read($id = null)
    {
        $data = null;

        try {
            if (is_string($data = $this->readSession($id))) {
                if ($this->encrypted) {
                    // Decrypt the data using the default key
                    $data = \KORD\Crypt\Encrypt::getInstance($this->encrypted)->decode($data);
                } else {
                    // Decode the data
                    $data = $this->decode($data);
                }
                
                // Unserialize the data
                $data = $this->unserialize($data);
            } else {
                // Ignore these, session is valid, likely no data though.
            }
        } catch (\Exception $e) {
            // Error reading the session, usually a corrupt session.
            throw new Session\Exception('Error reading session data.', Session\Exception::SESSION_CORRUPT);
        }

        if (is_array($data)) {
            // Load the data locally
            $this->data = $data;
        }

        // Protection from session hijacking - check the fingerprint
        if ($this->check_ip OR $this->check_user_agent) {
            $user_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
            $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
            $fingerprint = sha1(($this->check_ip ? $user_ip : '') . ($this->check_user_agent ? $user_agent : ''));
            if ($this->get('USER_FINGERPRINT') !== $fingerprint) {
                if ($this->get('USER_FINGERPRINT')) {
                    // restart session
                    $this->write();
                    $this->destroyed = true;
                    $this->restart();
                    $this->data = [];
                    $this->regenerate(false);
                }
                // set new fingerprint
                $this->set('USER_FINGERPRINT', $fingerprint);
            }
        }

        if (!$this->get('SESSION_STARTED')) {
            $this->set('SESSION_STARTED', time());
        }

        // Protection from session fixation
        $expires = $this->get('SESSION_EXPIRES');
        if ($expires) {
            if (!$id AND time() > $expires) {
                $this->destroyed = false;
                $this->restart();
            }
        } else {
            $this->set('SESSION_EXPIRES', time() + $this->lifetime);
        }

        $id_expires = $this->get('SESSION_ID_EXPIRES');
        if ($id_expires) {
            if (!$id AND time() > $id_expires) {
                $this->set('SESSION_EXPIRES', time() + 30);
                $this->write();
                $this->destroyed = true;
                $this->restart();
                $this->regenerate(false);
            }
        } else {
            $this->set('SESSION_ID_EXPIRES', time() + $this->id_lifetime);
        }
    }

    /**
     * Generates a new session id and returns it.
     *
     *     $id = $session->regenerate();
     *
     * @param bool $delete_old_session  delete old session file?
     * @return  string
     */
    public function regenerate($delete_old_session = false)
    {
        $this->set('SESSION_ID_EXPIRES', time() + $this->id_lifetime);
        $this->set('SESSION_EXPIRES', time() + $this->lifetime);

        return $this->regenerateSession($delete_old_session);
    }

    /**
     * Sets the last_active timestamp and saves the session.
     *
     *     $session->write();
     *
     * [!!] Any errors that occur during session writing will be logged,
     * but not displayed, because sessions are written after output has
     * been sent.
     *
     * @return  boolean
     * @uses    Kohana::$log
     */
    public function write()
    {
        if (headers_sent() OR $this->destroyed) {
            // Session cannot be written when the headers are sent or when
            // the session has been destroyed
            return false;
        }

        // Set the last active timestamp
        $this->data['last_active'] = time();

        try {
            return $this->writeSession();
        } catch (\Exception $e) {
            // Log & ignore all errors when a write fails
            Core::$log->log(Level::ERROR, Exception::text($e));

            return false;
        }
    }

    /**
     * Completely destroy the current session.
     *
     *     $success = $session->destroy();
     *
     * @return  boolean
     */
    public function destroy()
    {
        if ($this->destroyed === false) {
            if ($this->destroyed = $this->destroySession()) {
                // The session has been destroyed, clear all data
                $this->data = [];
            }
        }

        return $this->destroyed;
    }

    /**
     * Restart the session.
     *
     *     $success = $session->restart();
     *
     * @return  boolean
     */
    public function restart()
    {
        if ($this->destroyed === false) {
            // Wipe out the current session.
            $this->destroy();
        }

        // Allow the new session to be saved
        $this->destroyed = false;

        $status = $this->restartSession();

        if ($status) {
            $this->set('SESSION_STARTED', time());
            $this->set('SESSION_ID_EXPIRES', time() + $this->id_lifetime);
            $this->set('SESSION_EXPIRES', time() + $this->lifetime);
        }

        return $status;
    }

    /**
     * Serializes the session data.
     *
     * @param   array  $data  data
     * @return  string
     */
    protected function serialize($data)
    {
        return serialize($data);
    }

    /**
     * Unserializes the session data.
     *
     * @param   string  $data  data
     * @return  array
     */
    protected function unserialize($data)
    {
        return unserialize($data);
    }

    /**
     * Encodes the session data using [base64_encode].
     *
     * @param   string  $data  data
     * @return  string
     */
    protected function encode($data)
    {
        return base64_encode($data);
    }

    /**
     * Decodes the session data using [base64_decode].
     *
     * @param   string  $data  data
     * @return  string
     */
    protected function decode($data)
    {
        return base64_decode($data);
    }

    /**
     * Loads the raw session data string and returns it.
     *
     * @param   string  $id session id
     * @return  string
     */
    abstract protected function readSession($id = null);

    /**
     * Generate a new session id and return it.
     *
     * @return  string
     */
    abstract protected function regenerateSession($delete_old_session = false);

    /**
     * Writes the current session.
     *
     * @return  boolean
     */
    abstract protected function writeSession();

    /**
     * Destroys the current session.
     *
     * @return  boolean
     */
    abstract protected function destroySession();

    /**
     * Restarts the current session.
     *
     * @return  boolean
     */
    abstract protected function restartSession();
}
