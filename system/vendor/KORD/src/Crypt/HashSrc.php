<?php

namespace KORD\Crypt;

/**
 * The Hash library provides one-way encryption of text and binary strings
 * using one of the supported algorithms
 * 
 * @copyright  (c) 2014 Andriy Strepetov
 */
class HashSrc
{
    const OUTPUT_STRING = false;
    const OUTPUT_BINARY = true;

    /**
     * @var  string  default instance name
     */
    public static $default = 'default';

    /**
     * @var  array  Hash class instances
     */
    protected static $instances = [];
    
    /**
     * @var array  Supported hash algorithms 
     */
    protected static $supported = [];

    /**
     * Get supported algorithms
     *
     * @return array
     */
    public static function getSupportedAlgorithms()
    {
        if (!empty(Hash::$supported)) {
            return Hash::$supported;
        }
        
        return Hash::$supported = hash_algos();
    }

    /**
     * Is the hash algorithm supported?
     *
     * @param  string $algorithm
     * @return bool
     */
    public static function isAlgorithmSupported($algorithm)
    {
        return in_array(strtolower($algorithm), Hash::getSupportedAlgorithms(), true);
    }

    /**
     * Sets a new instance of Hash. A key for HMAC must be
     * provided in $config
     *
     *     Hash::setInstance('custom', ['key' => 'foobar']);
     *
     * @param   string  $name   Hash instance name
     * @param   array   $config Hash instance config
     */
    public static function setInstance($name, $config)
    {
        if ($name === null) {
            // Use the default instance name
            $name = Hash::$default;
        }

        if (!isset($config['algo'])) {
            // Add the default algorithm
            $config['algo'] = 'sha256';
        }
        
        if (!isset($config['key'])) {
            $config['key'] = null;
        }
        
        if (!isset($config['output'])) {
            $config['output'] = Hash::OUTPUT_STRING;
        }
        
        // Create a new instance
        Hash::$instances[$name] = new Hash($config['algo'], $config['key'], $config['output']);
    }

    /**
     * Returns an instance of Hash.
     *
     *     $hash = Hash::getInstance();
     *
     * @param   string  $name   Hash instance name
     * @return  Hash
     */
    public static function getInstance($name = null)
    {
        if ($name === null) {
            // Use the default instance name
            $name = Hash::$default;
        }

        return Hash::$instances[$name];
    }

    /**
     * Creates a new mcrypt wrapper.
     *
     * @param   string  $algo   Hash algorithm
     * @param   string  $key    HMAC key
     * @param   string  $output When set to true, outputs raw binary data. false outputs lowercase hexits.
     */
    public function __construct($algo, $key, $output)
    {
        // Store the key, mode, and cipher
        $this->algo = $algo;
        $this->key = $key;
        $this->output = $output;
    }

    /**
     * Returns a generated hash value
     *
     *     $data = $hash->compute($data);
     *
     * @param   string  $data   data to be hashed
     * @return  string
     */
    public function compute($data)
    {
        if ($this->key) {
            return hash_hmac($this->algo, $data, $this->key, $this->output);
        } else {
            return hash($this->algo, $data, $this->output);
        }
    }
    
    /**
     * Get the output size
     *
     * @return int
     */
    public function getOutputSize()
    {
        return strlen($this->compute('data'));
    }

}
