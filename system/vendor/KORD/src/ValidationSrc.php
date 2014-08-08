<?php

namespace KORD;

use KORD\Core;
use KORD\Helper\Arr;
use KORD\Profiler;
use KORD\Validation\RuleAbstract;

/**
 * Array and variable validation.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */
class ValidationSrc implements \ArrayAccess
{

    // Bound values
    protected $bound = [];
    // Field rules
    protected $rules = [];
    // Field labels
    protected $labels = [];
    // Error list
    protected $errors = [];
    // Array to validate
    protected $data = [];
    // Default break rules chain on failure value
    protected $break_on_failure = false;

    /**
     * Sets the unique "any field" key and creates an ArrayObject from the
     * passed array.
     *
     * @param   array   $array  array to validate
     * @return  void
     */
    public function __construct(array $array)
    {
        $this->data = $array;
    }

    /**
     * Throws an exception because Validation is read-only.
     * Implements ArrayAccess method.
     *
     * @throws  \KORD\Exception
     * @param   string   $offset    key to set
     * @param   mixed    $value     value to set
     * @return  void
     */
    public function offsetSet($offset, $value)
    {
        throw new \KORD\Exception('Validation objects are read-only.');
    }

    /**
     * Checks if key is set in array data.
     * Implements ArrayAccess method.
     *
     * @param   string  $offset key to check
     * @return  bool    whether the key is set
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Throws an exception because Validation is read-only.
     * Implements ArrayAccess method.
     *
     * @throws  \KORD\Exception
     * @param   string  $offset key to unset
     * @return  void
     */
    public function offsetUnset($offset)
    {
        throw new \KORD\Exception('Validation objects are read-only.');
    }

    /**
     * Gets a value from the array data.
     * Implements ArrayAccess method.
     *
     * @param   string  $offset key to return
     * @return  mixed   value from array
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * Copies the current rules to a new array.
     *
     *     $copy = $array->copy($new_data);
     *
     * @param   array   $array  new data set
     * @return  Validation
     */
    public function copy(array $array)
    {
        // Create a copy of the current validation set
        $copy = clone $this;

        // Replace the data set
        $copy->data = $array;

        return $copy;
    }

    /**
     * Returns the array of data to be validated.
     *
     * @return  array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets or overwrites the label name for a field.
     *
     * @param   string  $field  field name
     * @param   string  $label  label
     * @param   boolean  $translate
     * @return  $this
     */
    public function setLabel($field, $label)
    {
        // Set the label for this field
        $this->labels[$field] = $label;

        return $this;
    }

    /**
     * Sets labels using an array.
     *
     * @param   array   $labels list of field => label names
     * @return  $this
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels + $this->labels;

        return $this;
    }

    /**
     * Returns field label, optionally untranslated
     * 
     * @param   string   $field
     * @param   boolean  $translate
     * @return  string
     */
    public function getLabel($field, $translate = true)
    {
        if (Arr::get($this->labels, $field) === null) {
            // Set the field label to the field name
            $this->labels[$field] = preg_replace('/[^\pL]+/u', ' ', $field);
            return $this->labels[$field];
        }
        // Get label
        return $this->translate($this->labels[$field], null, [], $translate);
    }

    /**
     * Set $break_on_failure value
     * 
     * @param boolean $value
     * @return  $this
     */
    public function setBreakOnFailure($value)
    {
        $this->break_on_failure = (bool) $value;

        return $this;
    }

    /**
     * Overwrites or appends rules to a field. Each rule will be executed once.
     * All rules must be string names of functions method names. Parameters must
     * match the parameters of the callback function exactly
     * 
     * If $breakChainOnFailure is true, then if the validator fails, the next validator in the chain,
     * if one exists, will not be executed.
     *
     * Aliases you can use in callback parameters:
     * - :validation - the validation object
     * - :field - the field name
     * - :value - the value of the field
     *
     *     // The "username" must not be empty and have a minimum length of 4
     *     $validation->addRule('username', 'notEmpty')
     *                ->addRule('username', 'minLength', [':value', 4]);
     *
     *     // The "password" field must match the "password_repeat" field
     *     $validation->addRule('password', 'matches', [':validation', 'password', 'password_repeat']);
     *
     *     // Using closure (anonymous function)
     *     $validation->addRule('index',
     *         function(\KORD\Validation $array, $field, $value)
     *         {
     *             if ($value > 6 AND $value < 10)
     *             {
     *                 $array->addError($field, 'custom');
     *             }
     *         }
     *         , [':validation', ':field', ':value']
     *     );
     *
     * [!!] Errors must be added manually when using closures!
     *
     * @param   string      $field  field name
     * @param   callback    $rule   valid PHP callback or closure
     * @param   array       $params extra parameters for the rule
     * @param  boolean      $array_values  use this rule to check array values?
     * @param  boolean      $break  break rules chain on validation failure?
     * @return  $this
     */
    public function addRule($field, $rule, $params = null, $array_values = false, $break = null)
    {
        if ($break === null) {
            // Default to $this->break_on_failure
            $break = $this->break_on_failure;
        }

        if ($field !== true AND ! isset($this->labels[$field])) {
            // Set the field label to the field name
            $this->labels[$field] = preg_replace('/[^\pL]+/u', ' ', $field);
        }

        if (is_string($rule) AND class_exists('\\KORD\\Validation\\' . $rule)) {
            $class_name = '\\KORD\\Validation\\' . $rule;
            $rule = new $class_name;
        }
        
        if (!is_array($params) AND !is_null($params)) {
            $params = [$params];
        }

        // Store the rule and params for this rule
        $this->rules[$field][] = [
            'rule' => $rule,
            'params' => $params,
            'array_values' => $array_values,
            'break' => $break
        ];

        return $this;
    }

    /**
     * Add rules using an array.
     *
     * @param   string  $field  field name
     * @param   array   $rules  list of callbacks
     * @return  $this
     */
    public function addRules($field, array $rules)
    {
        foreach ($rules as $rule) {
            $this->addRule($field, $rule[0], Arr::get($rule, 1), Arr::get($rule, 2, false), Arr::get($rule, 3));
        }

        return $this;
    }

    /**
     * Bind a value to a parameter definition.
     *
     *     // This allows you to use :model in the parameter definition of rules
     *     $validation->bind(':model', $model)
     *         ->rule('status', 'validStatus', [':model']);
     *
     * @param   string  $key    variable name or an array of variables
     * @param   mixed   $value  value
     * @return  $this
     */
    public function bind($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->bound[$name] = $value;
            }
        } else {
            $this->bound[$key] = $value;
        }

        return $this;
    }

    /**
     * Executes all validation rules. This should
     * typically be called within an if/else block.
     *
     *     if ($validation->check())
     *     {
     *          // The data is valid, do something here
     *     }
     *
     * @return  boolean
     */
    public function check()
    {
        if (Core::$profiling === true) {
            // Start a new benchmark
            $benchmark = Profiler::start('Validation', __FUNCTION__);
        }

        // New data set
        $data = $this->errors = [];

        // Store the original data because this class should not modify it post-validation
        $original = $this->data;

        // Get a list of the expected fields
        $expected = Arr::merge(array_keys($original), array_keys($this->labels));

        // Import the rules locally
        $rules = $this->rules;

        foreach ($expected as $field) {
            // Use the submitted value or null if no data exists
            $data[$field] = Arr::get($this, $field);

            if (isset($rules[true])) {
                if (!isset($rules[$field])) {
                    // Initialize the rules for this field
                    $rules[$field] = [];
                }

                // Append the rules
                $rules[$field] = array_merge($rules[$field], $rules[true]);
            }
        }

        // Overload the current array with the new one
        $this->data = $data;

        // Remove the rules that apply to every field
        unset($rules[true]);

        // Bind the validation object to :validation
        $this->bind(':validation', $this);
        // Bind the data to :data
        $this->bind(':data', $this->data);

        // Execute the rules
        foreach ($rules as $field => $set) {
            // Get the field value
            $initial_value = Arr::get($this, $field);

            // Bind the field name to :field
            $this->bind([':field' => $field]);

            foreach ($set as $array) {
                // Rules are defined as associative array
                extract($array);

                // Check value as array if $array_values === true
                $values = ($array_values === false) ? [$initial_value] : $initial_value;

                foreach ($values as $value) {
                    $rule_params = $params;

                    if ($rule_params === null) {
                        // Default to [':value']
                        $rule_params = [':value'];
                    }

                    // Bind the value to :value
                    $this->bind([':value' => $value]);

                    foreach ($rule_params as $key => $param) {
                        if (is_string($param) AND array_key_exists($param, $this->bound)) {
                            // Replace with bound value
                            $rule_params[$key] = $this->bound[$param];
                        }
                    }

                    // Default the error name to be the rule (except array and lambda rules)
                    $error_name = $rule;

                    if ($rule instanceof RuleAbstract) {
                        $rule_instance = clone $rule;
                        // set options using 3rd param of AddRule
                        if (!empty($params)) {
                            $rule_instance->setOptions($rule_params);
                        }
                        $passed = $rule_instance->isValid($value);
                        foreach ($rule_instance->getErrors() as $error) {
                            list($error_message, $error_params) = $error;
                            $this->addError($field, $error_message, $error_params);
                        }
                        $error_name = false;
                    } elseif (is_array($rule)) {
                        // Allows rule('field', [':model', 'someRule']);
                        if (is_string($rule[0]) AND array_key_exists($rule[0], $this->bound)) {
                            // Replace with bound value
                            $rule[0] = $this->bound[$rule[0]];
                        }

                        // This is an array callback, the method name is the error name
                        $error_name = $rule[1];
                        $passed = call_user_func_array($rule, $rule_params);
                    } elseif (!is_string($rule)) {
                        // This is a lambda function, there is no error name (errors must be added manually)
                        $error_name = false;
                        $passed = call_user_func_array($rule, $rule_params);
                    } elseif (strpos($rule, '::') === false) {
                        // Use a function call
                        $function = new \ReflectionFunction($rule);

                        // Call $function($this[$field], $param, ...) with Reflection
                        $passed = $function->invokeArgs($rule_params);
                    } else {
                        // Split the class and method of the rule
                        list($class, $method) = explode('::', $rule, 2);

                        // Use a static method call
                        $method = new \ReflectionMethod($class, $method);

                        // Call $Class::$method($this[$field], $param, ...) with Reflection
                        $passed = $method->invokeArgs(null, $rule_params);
                    }

                    if ($passed === false AND $error_name !== false) {
                        // Add the rule to the errors
                        $this->addError($field, $error_name, $rule_params);

                        // This field has an error, stop executing rules if $break === true
                        if ($break === true) {
                            break;
                        }
                    } elseif (isset($this->errors[$field])) {
                        // The callback added the error manually, stop checking rules if $break === true
                        if ($break === true) {
                            break;
                        }
                    }
                }
            }
        }

        // Restore the data to its original form
        $this->data = $original;

        if (isset($benchmark)) {
            // Stop benchmarking
            Profiler::stop($benchmark);
        }

        return empty($this->errors);
    }

    /**
     * Add an error to a field.
     *
     * @param   string  $field  field name
     * @param   string  $error  error message
     * @param   array   $params
     * @return  $this
     */
    public function addError($field, $error, array $params = null)
    {
        $this->errors[$field][] = [$error, $params];

        return $this;
    }

    /**
     * Returns the error messages.
     *
     * By default all messages are translated using the default language.
     * A string can be used as the parameter to specified the language
     * that the message was written in.
     *
     *     // Get errors in default language
     *     $errors = $validate->getErrors();
     *
     * @param   string   translation group
     * @param   mixed   translate the message
     * @return  array
     */
    public function getErrors($group = null, $translate = true)
    {
        // Create a new message list
        $messages = [];

        foreach ($this->errors as $field => $sets) {

            // Get the label for this field
            $label = $this->getLabel($field, $translate);

            foreach ($sets as $set) {
                list($error, $params) = $set;

                // Start the translation values list
                $values = [
                    ':field' => $label,
                ];

                $context = null;
                if ($params) {
                    foreach ($params as $key => $value) {
                        // Objects cannot be used in message files
                        if (is_object($value)) {
                            continue;
                        }

                        // All values must be strings
                        if (is_array($value)) {
                            // All values must be strings
                            $value = implode(', ', Arr::flatten($value));
                        }

                        // Check if a label for this parameter exists
                        if (isset($this->labels[$value])) {
                            // Use the label as the value, eg: related field name for "matches"
                            $value = $this->translate($this->labels[$value], null, [], $translate);
                        }

                        // Add each parameter as a numbered value, starting from 1
                        if (is_numeric($key)) {
                            $values[':param' . ($key + 1)] = $value;
                        } else {
                            $values[$key] = $value;
                        }

                        // Starting from 2nd parameter, detect context (1st is validation context)
                        if ($context === null AND ( !is_numeric($key) OR $key > 0) AND is_numeric($value)) {
                            $context = $value;
                        }
                    }
                }

                $path = "{$group}.{$field}.{$error}";

                if ($translate) {
                    if (($translated = $this->translate($path, $context, $values, $translate)) != $path) {
                        // Found path translation
                    } elseif (($translated = $this->translate('valid.' . $error, $context, $values, $translate)) != 'valid.' . $error) {
                        // Found a default translation for this error
                    } elseif (($translated = $this->translate($error, $context, $values, $translate)) != $error) {
                        // Found a text translation for this error
                    } else {
                        $translated = $path;
                    }
                    $message = $translated;
                } else {
                    // Do not translate, just replace the values
                    $message = strtr($error, $values);
                }

                // Add the message for this field
                $messages[$field][] = $message;
            }
        }

        return $messages;
    }

    /**
     * Uses `__()` function to translate any text
     * 
     * @param   string   $string
     * @param   string   $context
     * @param   array    $values
     * @param   string   $lang
     * @return  string
     */
    protected function translate($string, $context = 0, $values = null, $lang = null)
    {
        if ($lang === true) {
            // Use current language
            $lang = null;
        }
        $translation = __($string, $context, $values, $lang);
        if (is_array($translation)) {
            // Found translation is actually a subsection of translations.
            // Return the original string as if the translation didn't exist.
            return $string;
        }
        return $translation;
    }

}
