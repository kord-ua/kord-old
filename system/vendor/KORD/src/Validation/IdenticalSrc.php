<?php

namespace KORD\Validation;

class IdenticalSrc extends RuleAbstract
{

    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'token' => null,
        'strict' => true,
        'literal' => false
    ];

    /**
     * Retrieve token
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->options['token'];
    }

    /**
     * Set token against which to compare
     *
     * @param  mixed $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->options['token'] = $token;
        return $this;
    }

    /**
     * Returns the strict parameter
     *
     * @return bool
     */
    public function getStrict()
    {
        return $this->options['strict'];
    }

    /**
     * Sets the strict parameter
     *
     * @param  bool $strict
     * @return $this
     */
    public function setStrict($strict)
    {
        $this->options['strict'] = (bool) $strict;
        return $this;
    }

    /**
     * Returns the literal parameter
     *
     * @return bool
     */
    public function getLiteral()
    {
        return $this->options['literal'];
    }

    /**
     * Sets the literal parameter
     *
     * @param  bool $literal
     * @return $this
     */
    public function setLiteral($literal)
    {
        $this->options['literal'] = (bool) $literal;
        return $this;
    }

    /**
     * Returns true if and only if a token has been set and the provided value
     * matches that token.
     *
     * @param  mixed $value
     * @param  array $context
     * @return bool
     */
    public function isValid($value, array $context = null)
    {
        $token = $this->getToken();

        if (!$this->getLiteral() AND $context !== null) {
            if (is_array($token)) {
                while (is_array($token)) {
                    $key = key($token);
                    if (!isset($context[$key])) {
                        break;
                    }
                    $context = $context[$key];
                    $token = $token[$key];
                }
            }

            // if $token is an array it means the above loop didn't went all the way down to the leaf,
            // so the $token structure doesn't match the $context structure
            if (is_array($token) OR !isset($context[$token])) {
                $token = $this->getToken();
            } else {
                $token = $context[$token];
            }
        }

        if ($token === null) {
            $this->addError('missingToken');
            return false;
        }

        $strict = $this->getStrict();
        if (($strict AND ($value !== $token)) OR (!$strict AND ($value != $token))) {
            $this->addError('notSame');
            return false;
        }

        return true;
    }

}
