<?php

/**
 * [Object Relational Mapping][ref-orm] (ORM) is a method of abstracting database
 * access to standard PHP calls. All table rows are represented as model objects,
 * with object properties representing row data. ORM in KORD generally follows
 * the [Active Record][ref-act] pattern.
 *
 * [ref-orm]: http://wikipedia.org/wiki/Object-relational_mapping
 * [ref-act]: http://wikipedia.org/wiki/Active_record
 *
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD;

use KORD\Database;
use KORD\DB;
use KORD\Filtration\Word\CamelCaseToUnderscore;
use KORD\Filtration\Word\UnderscoreToCamelCase;
use KORD\Helper\Arr;
use KORD\Helper\Inflector;
use KORD\ORM\Cache as ORMCache;
use KORD\ORM\Exception as ORMException;

abstract class ORMSrc implements \Serializable
{

    /**
     * "Has one" relationships
     * @var array
     */
    protected $has_one = [];

    /**
     * "Belongs to" relationships
     * @var array
     */
    protected $belongs_to = [];

    /**
     * "Has many" relationships
     * @var array
     */
    protected $has_many = [];

    /**
     * Relationships that should always be joined
     * @var array
     */
    protected $load_with = [];

    /**
     * Current object
     * @var array
     */
    protected $object = [];

    /**
     * @var array
     */
    protected $changed = [];

    /**
     * @var array
     */
    protected $original_values = [];

    /**
     * @var array
     */
    protected $related = [];

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * @var bool
     */
    protected $saved = false;

    /**
     * @var array
     */
    protected $sorting;

    /**
     * Foreign key suffix
     * @var string
     */
    protected $foreign_key_suffix = '_id';

    /**
     * Model name
     * @var string
     */
    protected $object_name;

    /**
     * Table name
     * @var string
     */
    protected $table_name;

    /**
     * Table columns
     * @var array
     */
    protected $table_columns;

    /**
     * Auto-update columns for updates
     * @var string
     */
    protected $updated_column = null;

    /**
     * Auto-update columns for creation
     * @var string
     */
    protected $created_column = null;

    /**
     * Auto-serialize and unserialize columns on get/set
     * @var array
     */
    protected $serialize_columns = [];

    /**
     * Table primary key
     * @var string
     */
    protected $primary_key = 'id';

    /**
     * Primary key value
     * @var mixed
     */
    protected $primary_key_value;

    /**
     * Model configuration, reload on wakeup?
     * @var bool
     */
    protected $reload_on_wakeup = true;

    /**
     * Database Object
     * @var \KORD\Database
     */
    protected $db = null;

    /**
     * Database config group
     * @var string
     */
    protected $db_group = null;

    /**
     * Database methods applied
     * @var array
     */
    protected $db_applied = [];

    /**
     * Database methods pending
     * @var array
     */
    protected $db_pending = [];

    /**
     * Reset builder
     * @var bool
     */
    protected $db_reset = true;

    /**
     * Database query builder
     * @var \KORD\Database\QueryBuilder\Select
     */
    protected $db_builder;

    /**
     * With calls already applied
     * @var array
     */
    protected $with_applied = [];

    /**
     * Data to be loaded into the model from a database call cast
     * @var array
     */
    protected $cast_data = [];

    /**
     * Constructs a new model and loads a record if given
     *
     * @param   mixed $id Parameter for find or object to load
     */
    public function __construct($id = null)
    {
        $this->initialize();

        if ($id !== null) {
            if (is_array($id)) {
                foreach ($id as $column => $value) {
                    // Passing an array of column => values
                    $this->where($column, '=', $value);
                }

                $this->find();
            } else {
                // Passing the primary key
                $this->where($this->object_name . '.' . $this->primary_key, '=', $id)->find();
            }
        } elseif (!empty($this->cast_data)) {
            // Load preloaded data from a database call cast
            $this->loadValues($this->cast_data);

            $this->cast_data = [];
        }
    }

    /**
     * Prepares the model database connection, determines the table name,
     * and loads column information.
     *
     * @return void
     */
    protected function initialize()
    {
        // Set the object name if none predefined
        if (empty($this->object_name)) {
            $object_name = substr(get_class($this), strrpos(get_class($this), '\\') + 1, -5);
            $this->object_name = (new CamelCaseToUnderscore(true))->filter($object_name);
        }

        // Check if this model has already been initialized
        if (!$init = ORMCache::instance()->getInitCache($this->object_name)) {
            $init = [
                'belongs_to' => [],
                'has_one' => [],
                'has_many' => [],
            ];

            if (!is_object($this->db)) {
                // Get database instance
                $init['db'] = Database::instance($this->db_group);
            }

            if (empty($this->table_name)) {
                // Table name is made from object name in plural form
                $init['table_name'] = Inflector::plural($this->object_name);
            }

            $defaults = [];

            foreach ($this->belongs_to as $alias => $details) {
                if (!isset($details['model'])) {
                    $defaults['model'] = (new UnderscoreToCamelCase(true))->filter($alias);
                }

                $defaults['foreign_key'] = $alias . $this->foreign_key_suffix;

                $init['belongs_to'][$alias] = array_merge($defaults, $details);
            }

            foreach ($this->has_one as $alias => $details) {
                if (!isset($details['model'])) {
                    $defaults['model'] = (new UnderscoreToCamelCase(true))->filter($alias);
                }

                $defaults['foreign_key'] = $this->object_name . $this->foreign_key_suffix;

                $init['has_one'][$alias] = array_merge($defaults, $details);
            }

            foreach ($this->has_many as $alias => $details) {
                if (!isset($details['model'])) {
                    $defaults['model'] = (new UnderscoreToCamelCase(true))->filter(Inflector::singular($alias));
                }

                $defaults['foreign_key'] = $this->object_name . $this->foreign_key_suffix;
                $defaults['through'] = null;

                if (!isset($details['far_key'])) {
                    $defaults['far_key'] = Inflector::singular($alias) . $this->foreign_key_suffix;
                }

                $init['has_many'][$alias] = array_merge($defaults, $details);
            }

            ORMCache::instance()->setInitCache($init, $this->object_name);
        }

        // Assign initialized properties to the current object
        foreach ($init as $property => $value) {
            $this->{$property} = $value;
        }

        // Load column information
        $this->reloadColumns();

        // Clear initial model state
        $this->clear();
    }

    /**
     * Reload column definitions.
     *
     * @chainable
     * @param   boolean $force Force reloading
     * @return  $this
     */
    public function reloadColumns($force = false)
    {
        if ($force === true OR empty($this->table_columns)) {
            if ($cache = ORMCache::instance()->getColumnCache($this->object_name)) {
                // Use cached column information
                $this->table_columns = $cache;
            } else {
                // Grab column information from database
                $this->table_columns = $this->listColumns();

                // Load column cache
                ORMCache::instance()->setColumnCache($this->table_columns, $this->object_name);
            }
        }

        return $this;
    }

    /**
     * Unloads the current object and clears the status.
     *
     * @chainable
     * @return $this
     */
    public function clear()
    {
        // Create an array with all the columns set to null
        $values = (empty($this->table_columns) ? [] : array_combine(array_values($this->table_columns), array_fill(0, count($this->table_columns), null)));

        // Replace the object and reset the object status
        $this->object = $this->changed = $this->related = $this->original_values = [];

        // Replace the current object with an empty one
        $this->loadValues($values);

        // Reset primary key
        $this->primary_key_value = null;

        // Reset the loaded state
        $this->loaded = false;

        $this->reset();

        return $this;
    }

    /**
     * Reloads the current object from the database.
     *
     * @chainable
     * @return $this
     */
    public function reload()
    {
        $primary_key = $this->pk();

        // Replace the object and reset the object status
        $this->object = $this->changed = $this->related = $this->original_values = [];

        // Only reload the object if we have one to reload
        if ($this->loaded) {
            return $this->clear()
                            ->where($this->object_name . '.' . $this->primary_key, '=', $primary_key)
                            ->find();
        } else {
            return $this->clear();
        }
    }

    /**
     * Checks if object data is set.
     *
     * @param  string $column Column name
     * @return boolean
     */
    public function __isset($column)
    {
        return (isset($this->object[$column]) OR
                isset($this->related[$column]) OR
                isset($this->has_one[$column]) OR
                isset($this->belongs_to[$column]) OR
                isset($this->has_many[$column]));
    }

    /**
     * Unsets object data.
     *
     * @param  string $column Column name
     * @return void
     */
    public function __unset($column)
    {
        unset($this->object[$column], $this->changed[$column], $this->related[$column]);
    }

    /**
     * Displays the primary key of a model when it is converted to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->pk();
    }

    /**
     * Allows serialization of only the object data and state, to prevent
     * "stale" objects being unserialized, which also requires less memory.
     *
     * @return string
     */
    public function serialize()
    {
        // Store only information about the object
        foreach (['primary_key_value', 'object', 'changed', 'loaded', 'saved', 'sorting', 'original_values'] as $var) {
            $data[$var] = $this->{$var};
        }

        return serialize($data);
    }

    /**
     * Check whether the model data has been modified.
     * If $field is specified, checks whether that field was modified.
     *
     * @param string  $field  field to check for changes
     * @return  bool  Whether or not the field has changed
     */
    public function changed($field = null)
    {
        return ($field === null) ? $this->changed : Arr::get($this->changed, $field);
    }

    /**
     * Prepares the database connection and reloads the object.
     *
     * @param string $data String for unserialization
     * @return  void
     */
    public function unserialize($data)
    {
        // Initialize model
        $this->initialize();

        foreach (unserialize($data) as $name => $var) {
            $this->{$name} = $var;
        }

        if ($this->reload_on_wakeup === true) {
            // Reload the object
            $this->reload();
        }
    }

    /**
     * Handles retrieval of all model values, relationships, and metadata.
     * [!!] This should not be overridden.
     *
     * @param   string $column Column name
     * @return  mixed
     */
    public function __get($column)
    {
        return $this->get($column);
    }

    /**
     * Handles getting of column
     * Override this method to add custom get behavior
     *
     * @param   string $column Column name
     * @throws \KORD\ORM\Exception
     * @return mixed
     */
    public function get($column)
    {
        if (array_key_exists($column, $this->object)) {
            return (in_array($column, $this->serialize_columns)) ? $this->unserializeValue($this->object[$column]) : $this->object[$column];
        } elseif (isset($this->related[$column])) {
            // Return related model that has already been fetched
            return $this->related[$column];
        } elseif (isset($this->belongs_to[$column])) {
            $model = $this->related($column);

            // Use this model's column and foreign model's primary key
            $col = $model->object_name . '.' . $model->primary_key;
            $val = $this->object[$this->belongs_to[$column]['foreign_key']];

            // Make sure we don't run WHERE "AUTO_INCREMENT column" = null queries. This would
            // return the last inserted record instead of an empty result.
            // See: http://mysql.localhost.net.ar/doc/refman/5.1/en/server-session-variables.html#sysvar_sql_auto_is_null
            if ($val !== null) {
                $model->where($col, '=', $val)->find();
            }

            return $this->related[$column] = $model;
        } elseif (isset($this->has_one[$column])) {
            $model = $this->related($column);

            // Use this model's primary key value and foreign model's column
            $col = $model->object_name . '.' . $this->has_one[$column]['foreign_key'];
            $val = $this->pk();

            $model->where($col, '=', $val)->find();

            return $this->related[$column] = $model;
        } elseif (isset($this->has_many[$column])) {
            $model_class = ucfirst($this->has_many[$column]['model']) . 'Model';
            if (!class_exists($model_class)) {
                $model_class = substr(get_class($this), 0, strrpos(get_class($this), '\\')+1).$model_class;
            }
            $model = new $model_class;

            if (isset($this->has_many[$column]['through'])) {
                // Grab has_many "through" relationship table
                $through = $this->has_many[$column]['through'];

                // Join on through model's target foreign key (far_key) and target model's primary key
                $join_col1 = $through . '.' . $this->has_many[$column]['far_key'];
                $join_col2 = $model->object_name . '.' . $model->primary_key;

                $model->join($through)->on($join_col1, '=', $join_col2);

                // Through table's source foreign key (foreign_key) should be this model's primary key
                $col = $through . '.' . $this->has_many[$column]['foreign_key'];
                $val = $this->pk();
            } else {
                // Simple has_many relationship, search where target model's foreign key is this model's primary key
                $col = $model->object_name . '.' . $this->has_many[$column]['foreign_key'];
                $val = $this->pk();
            }

            return $model->where($col, '=', $val);
        } else {
            throw new ORMException("The '{property}' property does not exist in the '{class}' class", ['property' => $column, 'class' => get_class($this)]);
        }
    }

    /**
     * Base set method.
     * [!!] This should not be overridden.
     *
     * @param  string $column  Column name
     * @param  mixed  $value   Column value
     * @return void
     */
    public function __set($column, $value)
    {
        $this->set($column, $value);
    }

    /**
     * Handles setting of columns
     * Override this method to add custom set behavior
     *
     * @param  string $column Column name
     * @param  mixed  $value  Column value
     * @throws \KORD\ORM\Exception
     * @return $this
     */
    public function set($column, $value)
    {
        if (!isset($this->object_name)) {
            // Object not yet constructed, so we're loading data from a database call cast
            $this->cast_data[$column] = $value;

            return $this;
        }

        if (in_array($column, $this->serialize_columns)) {
            $value = $this->serializeValue($value);
        }

        if (array_key_exists($column, $this->object) OR !isset($this->belongs_to[$column])) {
            // See if the data really changed
            if (!array_key_exists($column, $this->object) OR $value !== $this->object[$column]) {
                $this->object[$column] = $value;

                // Data has changed
                $this->changed[$column] = $column;

                // Object is no longer saved
                $this->saved = false;
            }
        } else {
            // Update related object itself
            $this->related[$column] = $value;

            // Update the foreign key of this model
            $this->object[$this->belongs_to[$column]['foreign_key']] = ($value instanceof ORMSrc) ? $value->pk() : null;

            $this->changed[$column] = $this->belongs_to[$column]['foreign_key'];
        }

        return $this;
    }

    /**
     * Set values from an array with support for one-one relationships.  This method should be used
     * for loading in post data, etc.
     *
     * @param  array $values   Array of column => val
     * @param  array $expected Array of keys to take from $values
     * @return $this
     */
    public function values(array $values, array $expected = null)
    {
        // Default to expecting everything except the primary key
        if ($expected === null) {
            $expected = array_values($this->table_columns);

            // Don't set the primary key by default
            unset($values[$this->primary_key]);
        }

        foreach ($expected as $key => $column) {
            if (is_string($key)) {
                // isset() fails when the value is null (we want it to pass)
                if (!array_key_exists($key, $values)) {
                    continue;
                }

                // Try to set values to a related model
                $this->{$key}->values($values[$key], $column);
            } else {
                // isset() fails when the value is null (we want it to pass)
                if (!array_key_exists($column, $values)) {
                    continue;
                }

                // Update the column, respects __set()
                $this->$column = $values[$column];
            }
        }

        return $this;
    }

    /**
     * Returns the values of this object as an array, including any related one-one
     * models that have already been loaded using with()
     *
     * @return array
     */
    public function asArray()
    {
        $object = [];

        foreach ($this->object as $column => $value) {
            // Call __get for any user processing
            $object[$column] = $this->__get($column);
        }

        foreach ($this->related as $column => $model) {
            // Include any related objects that are already loaded
            $object[$column] = $model->asArray();
        }

        return $object;
    }

    /**
     * Binds another one-to-one object to this model.  One-to-one objects
     * can be nested using 'object1:object2' syntax
     *
     * @param  string $target_path Target model to bind to
     * @return $this
     */
    public function with($target_path)
    {
        if (isset($this->with_applied[$target_path])) {
            // Don't join anything already joined
            return $this;
        }

        // Split object parts
        $aliases = explode(':', $target_path);
        $target = $this;
        foreach ($aliases as $alias) {
            // Go down the line of objects to find the given target
            $parent = $target;
            $target = $parent->related($alias);

            if (!$target) {
                // Can't find related object
                return $this;
            }
        }

        // Target alias is at the end
        $target_alias = $alias;

        // Pop-off top alias to get the parent path (user:photo:tag becomes user:photo - the parent table prefix)
        array_pop($aliases);
        $parent_path = implode(':', $aliases);

        if (empty($parent_path)) {
            // Use this table name itself for the parent path
            $parent_path = $this->object_name;
        } else {
            if (!isset($this->with_applied[$parent_path])) {
                // If the parent path hasn't been joined yet, do it first (otherwise LEFT JOINs fail)
                $this->with($parent_path);
            }
        }

        // Add to with_applied to prevent duplicate joins
        $this->with_applied[$target_path] = true;

        // Use the keys of the empty object to determine the columns
        foreach (array_keys($target->object) as $column) {
            $name = $target_path . '.' . $column;
            $alias = $target_path . ':' . $column;

            // Add the prefix so that load_result can determine the relationship
            $this->select([$name, $alias]);
        }

        if (isset($parent->belongs_to[$target_alias])) {
            // Parent belongs_to target, use target's primary key and parent's foreign key
            $join_col1 = $target_path . '.' . $target->primary_key;
            $join_col2 = $parent_path . '.' . $parent->belongs_to[$target_alias]['foreign_key'];
        } else {
            // Parent has_one target, use parent's primary key as target's foreign key
            $join_col1 = $parent_path . '.' . $parent->primary_key;
            $join_col2 = $target_path . '.' . $parent->has_one[$target_alias]['foreign_key'];
        }

        // Join the related object into the result
        $this->join([$target->table_name, $target_path], 'LEFT')->on($join_col1, '=', $join_col2);

        return $this;
    }

    /**
     * Initializes the Database Query Builder to given query type
     *
     * @param  integer $type Type of Database query
     * @return $this
     */
    protected function build($type)
    {
        // Construct new builder object based on query type
        switch ($type) {
            case Database::SELECT:
                $this->db_builder = DB::select();
                break;
            case Database::UPDATE:
                $this->db_builder = DB::update([$this->table_name, $this->object_name]);
                break;
            case Database::DELETE:
                // Cannot use an alias for DELETE queries
                $this->db_builder = DB::delete($this->table_name);
        }

        // Process pending database method calls
        foreach ($this->db_pending as $method) {
            $name = $method['name'];
            $args = $method['args'];

            $this->db_applied[$name] = $name;

            call_user_func_array([$this->db_builder, $name], $args);
        }

        return $this;
    }

    /**
     * Finds and loads a single database row into the object.
     *
     * @chainable
     * @throws \KORD\ORM\Exception
     * @return $this
     */
    public function find()
    {
        if ($this->loaded) {
            throw new ORMException('Method find() cannot be called on loaded objects');
        }

        if (!empty($this->load_with)) {
            foreach ($this->load_with as $alias) {
                // Bind auto relationships
                $this->with($alias);
            }
        }

        $this->build(Database::SELECT);

        return $this->loadResult(false);
    }

    /**
     * Finds multiple database rows and returns an iterator of the rows found.
     *
     * @throws \KORD\ORM\Exception
     * @return \KORD\Database\Result
     */
    public function findAll()
    {
        if ($this->loaded) {
            throw new ORMException('Method find_all() cannot be called on loaded objects');
        }

        if (!empty($this->load_with)) {
            foreach ($this->load_with as $alias) {
                // Bind auto relationships
                $this->with($alias);
            }
        }

        $this->build(Database::SELECT);

        return $this->loadResult(true);
    }

    /**
     * Returns an array of columns to include in the select query. This method
     * can be overridden to change the default select behavior.
     *
     * @return array Columns to select
     */
    protected function buildSelect()
    {
        $columns = [];

        foreach ($this->table_columns as $column) {
            $columns[] = [$this->object_name . '.' . $column, $column];
        }

        return $columns;
    }

    /**
     * Loads a database result, either as a new record for this model, or as
     * an iterator for multiple rows.
     *
     * @chainable
     * @param  bool $multiple Return an iterator or load a single row
     * @return $this|\KORD\Database\Result
     */
    protected function loadResult($multiple = false)
    {
        $this->db_builder->from([$this->table_name, $this->object_name]);

        if ($multiple === false) {
            // Only fetch 1 record
            $this->db_builder->limit(1);
        }

        // Select all columns by default
        $this->db_builder->selectArray($this->buildSelect());

        if (!isset($this->db_applied['order_by']) AND ! empty($this->sorting)) {
            foreach ($this->sorting as $column => $direction) {
                if (strpos($column, '.') === false) {
                    // Sorting column for use in JOINs
                    $column = $this->object_name . '.' . $column;
                }

                $this->db_builder->orderBy($column, $direction);
            }
        }

        if ($multiple === true) {
            // Return database iterator casting to this object type
            $result = $this->db_builder->asObject(get_class($this))->execute($this->db);

            $this->reset();

            return $result;
        } else {
            // Load the result as an associative array
            $result = $this->db_builder->asAssoc()->execute($this->db);

            $this->reset();

            if ($result->count() === 1) {
                // Load object values
                $this->loadValues($result->current());
            } else {
                // Clear the object, nothing was found
                $this->clear();
            }

            return $this;
        }
    }

    /**
     * Loads an array of values into into the current object.
     *
     * @chainable
     * @param  array $values Values to load
     * @return $this
     */
    protected function loadValues(array $values)
    {
        if (array_key_exists($this->primary_key, $values)) {
            if ($values[$this->primary_key] !== null) {
                // Flag as loaded
                $this->loaded = true;

                // Store primary key
                $this->primary_key_value = $values[$this->primary_key];
            } else {
                // Not loaded
                $this->loaded = false;
            }
        }

        // Related objects
        $related = [];

        foreach ($values as $column => $value) {
            if (strpos($column, ':') === false) {
                // Load the value to this model
                $this->object[$column] = $value;
            } else {
                // Column belongs to a related model
                list ($prefix, $column) = explode(':', $column, 2);

                $related[$prefix][$column] = $value;
            }
        }

        if (!empty($related)) {
            foreach ($related as $object => $values) {
                // Load the related objects with the values in the result
                $this->related($object)->loadValues($values);
            }
        }

        if ($this->loaded) {
            // Store the object in its original state
            $this->original_values = $this->object;
        }

        return $this;
    }

    /**
     * Insert a new object to the database
     * @throws \KORD\ORM\Exception
     * @return $this
     */
    public function create()
    {
        if ($this->loaded) {
            throw new ORMException("Cannot create '{model}' model because it is already loaded.", ['model' => $this->object_name]);
        }

        $data = [];
        foreach ($this->changed as $column) {
            // Generate list of column => values
            $data[$column] = $this->object[$column];
        }

        if (is_array($this->created_column)) {
            // Fill the created column
            $column = $this->created_column['column'];
            $format = $this->created_column['format'];

            $data[$column] = $this->object[$column] = ($format === true) ? time() : date($format);
        }

        $result = DB::insert($this->table_name)
                ->columns(array_keys($data))
                ->values(array_values($data))
                ->execute($this->db);

        if (!array_key_exists($this->primary_key, $data)) {
            // Load the insert id as the primary key if it was left out
            $this->object[$this->primary_key] = $this->primary_key_value = $result[0];
        } else {
            $this->primary_key_value = $this->object[$this->primary_key];
        }

        // Object is now loaded and saved
        $this->loaded = $this->saved = true;

        // All changes have been saved
        $this->changed = [];
        $this->original_values = $this->object;

        return $this;
    }

    /**
     * Updates a single record or multiple records
     *
     * @chainable
     * @throws \KORD\ORM\Exception
     * @return $this
     */
    public function update()
    {
        if (!$this->loaded) {
            throw new ORMException("Cannot update '{model}' model because it is not loaded.", ['model' => $this->object_name]);
        }

        if (empty($this->changed)) {
            // Nothing to update
            return $this;
        }

        $data = [];
        foreach ($this->changed as $column) {
            // Compile changed data
            $data[$column] = $this->object[$column];
        }

        if (is_array($this->updated_column)) {
            // Fill the updated column
            $column = $this->updated_column['column'];
            $format = $this->updated_column['format'];

            $data[$column] = $this->object[$column] = ($format === true) ? time() : date($format);
        }

        // Use primary key value
        $id = $this->pk();

        // Update a single record
        DB::update($this->table_name)
                ->set($data)
                ->where($this->primary_key, '=', $id)
                ->execute($this->db);

        if (isset($data[$this->primary_key])) {
            // Primary key was changed, reflect it
            $this->primary_key_value = $data[$this->primary_key];
        }

        // Object has been saved
        $this->saved = true;

        // All changes have been saved
        $this->changed = [];
        $this->original_values = $this->object;

        return $this;
    }

    /**
     * Updates or Creates the record depending on isLoaded()
     *
     * @chainable
     * @return $this
     */
    public function save()
    {
        return $this->isLoaded() ? $this->update() : $this->create();
    }

    /**
     * Deletes a single record while ignoring relationships.
     *
     * @chainable
     * @throws \KORD\ORM\Exception
     * @return $this
     */
    public function delete()
    {
        if (!$this->loaded) {
            throw new ORMException("Cannot delete '{model}' model because it is not loaded.", ['model' => $this->object_name]);
        }

        // Use primary key value
        $id = $this->pk();

        // Delete the object
        DB::delete($this->table_name)
                ->where($this->primary_key, '=', $id)
                ->execute($this->db);

        return $this->clear();
    }

    /**
     * Tests if this object has a relationship to a different model,
     * or an array of different models. When providing far keys, the number
     * of relations must equal the number of keys.
     *
     *     // Check if $model has the login role
     *     $model->has('roles', new RoleModel(['name' => 'login']));
     *     // Check for the login role if you know the roles.id is 5
     *     $model->has('roles', 5);
     *     // Check for all of the following roles
     *     $model->has('roles', [1, 2, 3, 4]);
     *     // Check if $model has any roles
     *     $model->has('roles')
     *
     * @param  string  $alias    Alias of the has_many "through" relationship
     * @param  mixed   $far_keys Related model, primary key, or an array of primary keys
     * @return boolean
     */
    public function has($alias, $far_keys = null)
    {
        $count = $this->countRelations($alias, $far_keys);
        if ($far_keys === null) {
            return (bool) $count;
        } else {
            return $count === count($far_keys);
        }
    }

    /**
     * Tests if this object has a relationship to a different model,
     * or an array of different models. When providing far keys, this function
     * only checks that at least one of the relationships is satisfied.
     *
     *     // Check if $model has the login role
     *     $model->hasAny('roles', new RoleModel(['name' => 'login']));
     *     // Check for the login role if you know the roles.id is 5
     *     $model->hasAny('roles', 5);
     *     // Check for any of the following roles
     *     $model->hasAny('roles', [1, 2, 3, 4]);
     *     // Check if $model has any roles
     *     $model->hasAny('roles')
     *
     * @param  string  $alias    Alias of the has_many "through" relationship
     * @param  mixed   $far_keys Related model, primary key, or an array of primary keys
     * @return boolean
     */
    public function hasAny($alias, $far_keys = null)
    {
        return (bool) $this->countRelations($alias, $far_keys);
    }

    /**
     * Returns the number of relationships
     *
     *     // Counts the number of times the login role is attached to $model
     *     $model->countRelations('roles', new RoleModel(['name' => 'login']));
     *     // Counts the number of times role 5 is attached to $model
     *     $model->countRelations('roles', 5);
     *     // Counts the number of times any of roles 1, 2, 3, or 4 are attached to
     *     // $model
     *     $model->countRelations('roles', [1, 2, 3, 4]);
     *     // Counts the number roles attached to $model
     *     $model->countRelations('roles')
     *
     * @param  string  $alias    Alias of the has_many "through" relationship
     * @param  mixed   $far_keys Related model, primary key, or an array of primary keys
     * @return integer
     */
    public function countRelations($alias, $far_keys = null)
    {
        if ($far_keys === null) {
            return (int) DB::select([DB::expr('COUNT(*)'), 'records_found'])
                            ->from($this->has_many[$alias]['through'])
                            ->where($this->has_many[$alias]['foreign_key'], '=', $this->pk())
                            ->execute($this->db)->get('records_found');
        }

        $far_keys = ($far_keys instanceof ORMSrc) ? $far_keys->pk() : $far_keys;

        // We need an array to simplify the logic
        $far_keys = (array) $far_keys;

        // Nothing to check if the model isn't loaded or we don't have any far_keys
        if (!$far_keys OR ! $this->loaded) {
            return 0;
        }

        $count = (int) DB::select([DB::expr('COUNT(*)'), 'records_found'])
                        ->from($this->has_many[$alias]['through'])
                        ->where($this->has_many[$alias]['foreign_key'], '=', $this->pk())
                        ->where($this->has_many[$alias]['far_key'], 'IN', $far_keys)
                        ->execute($this->db)->get('records_found');

        // Rows found need to match the rows searched
        return (int) $count;
    }

    /**
     * Adds a new relationship to between this model and another.
     *
     *     // Add the login role using a model instance
     *     $model->add('roles', new RoleModel(['name' => 'login']));
     *     // Add the login role if you know the roles.id is 5
     *     $model->add('roles', 5);
     *     // Add multiple roles (for example, from checkboxes on a form)
     *     $model->add('roles', [1, 2, 3, 4]);
     *
     * @param  string  $alias    Alias of the has_many "through" relationship
     * @param  mixed   $far_keys Related model, primary key, or an array of primary keys
     * @return $this
     */
    public function add($alias, $far_keys)
    {
        $far_keys = ($far_keys instanceof ORMSrc) ? $far_keys->pk() : $far_keys;

        $columns = [$this->has_many[$alias]['foreign_key'], $this->has_many[$alias]['far_key']];
        $foreign_key = $this->pk(); 

        $query = DB::insert($this->has_many[$alias]['through'], $columns);

        foreach ((array) $far_keys as $key) {
            $query->values([$foreign_key, $key]);
        }

        $query->execute($this->db);

        return $this;
    }

    /**
     * Removes a relationship between this model and another.
     *
     *     // Remove a role using a model instance
     *     $model->remove('roles', new RoleModel(['name' => 'login']));
     *     // Remove the role knowing the primary key
     *     $model->remove('roles', 5);
     *     // Remove multiple roles (for example, from checkboxes on a form)
     *     $model->remove('roles', [1, 2, 3, 4]);
     *     // Remove all related roles
     *     $model->remove('roles');
     *
     * @param  string $alias    Alias of the has_many "through" relationship
     * @param  mixed  $far_keys Related model, primary key, or an array of primary keys
     * @return $this
     */
    public function remove($alias, $far_keys = null)
    {
        $far_keys = ($far_keys instanceof ORMSrc) ? $far_keys->pk() : $far_keys;

        $query = DB::delete($this->has_many[$alias]['through'])
                ->where($this->has_many[$alias]['foreign_key'], '=', $this->pk());

        if ($far_keys !== NULL) {
            // Remove all the relationships in the array
            $query->where($this->has_many[$alias]['far_key'], 'IN', (array) $far_keys);
        }

        $query->execute($this->db);

        return $this;
    }

    /**
     * Count the number of records in the table.
     *
     * @return integer
     */
    public function countAll()
    {
        $selects = [];

        foreach ($this->db_pending as $key => $method) {
            if ($method['name'] == 'select') {
                // Ignore any selected columns for now
                $selects[] = $method;
                unset($this->db_pending[$key]);
            }
        }

        if (!empty($this->load_with)) {
            foreach ($this->load_with as $alias) {
                // Bind relationship
                $this->with($alias);
            }
        }

        $this->build(Database::SELECT);

        $records = $this->db_builder->from([$this->table_name, $this->object_name])
                ->select([DB::expr('COUNT(' . $this->db->quoteColumn($this->object_name . '.' . $this->primary_key) . ')'), 'records_found'])
                ->execute($this->db)
                ->get('records_found');

        // Add back in selected columns
        $this->db_pending += $selects;

        $this->reset();

        // Return the total number of records in a table
        return (int) $records;
    }

    /**
     * Returns list of table columns if at least 1 table record exists
     * otherwise returns empty array
     *
     * @return array
     */
    public function listColumns()
    {
        $sql = \KORD\DB::select()
                ->from($this->table_name)
                ->limit(1)
                ->execute()
                ->current();

        return (is_array($sql) ? array_keys($sql) : []);
    }

    /**
     * Returns an ORM model for the given one-one related alias
     *
     * @param  string $alias Alias name
     * @return $this
     */
    protected function related($alias)
    {
        if (isset($this->related[$alias])) {
            return $this->related[$alias];
        } elseif (isset($this->has_one[$alias])) {
            $classname = $this->has_one[$alias]['model'] . 'Model';
            if (!class_exists($classname)) {
                $classname = substr(get_class($this), 0, strrpos(get_class($this), '\\')+1).$classname;
            }
            return $this->related[$alias] = new $classname;
        } elseif (isset($this->belongs_to[$alias])) {
            $classname = $this->belongs_to[$alias]['model'] . 'Model';
            if (!class_exists($classname)) {
                $classname = substr(get_class($this), 0, strrpos(get_class($this), '\\')+1).$classname;
            }
            return $this->related[$alias] = new $classname;
        } else {
            return false;
        }
    }

    /**
     * Returns the value of the primary key
     *
     * @return mixed Primary key
     */
    public function pk()
    {
        return $this->primary_key_value;
    }

    /**
     * Returns last executed query
     *
     * @return string
     */
    public function lastQuery()
    {
        return $this->db->last_query;
    }

    /**
     * Clears query builder.  Passing false is useful to keep the existing
     * query conditions for another query.
     *
     * @param bool $next Pass false to avoid resetting on the next call
     * @return $this
     */
    public function reset($next = true)
    {
        if ($next AND $this->db_reset) {
            $this->db_pending = [];
            $this->db_applied = [];
            $this->db_builder = null;
            $this->with_applied = [];
        }

        // Reset on the next call?
        $this->db_reset = $next;

        return $this;
    }

    protected function serializeValue($value)
    {
        return json_encode($value);
    }

    protected function unserializeValue($value)
    {
        return json_decode($value, true);
    }

    public function getObjectName()
    {
        return $this->object_name;
    }

    public function isLoaded()
    {
        return $this->loaded;
    }

    public function isSaved()
    {
        return $this->saved;
    }

    public function getPrimaryKey()
    {
        return $this->primary_key;
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function getTableColumns()
    {
        return $this->table_columns;
    }

    public function hasOne()
    {
        return $this->has_one;
    }

    public function belongsTo()
    {
        return $this->belongs_to;
    }

    public function hasMany()
    {
        return $this->has_many;
    }

    public function loadWith()
    {
        return $this->load_with;
    }

    public function getOriginalValues()
    {
        return $this->original_values;
    }

    public function getCreatedColumn()
    {
        return $this->created_column;
    }

    public function getUpdatedColumn()
    {
        return $this->updated_column;
    }

    public function getObject()
    {
        return $this->object;
    }

    /**
     * Alias of andWhere()
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function where($column, $op, $value)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'where',
            'args' => [$column, $op, $value],
        ];

        return $this;
    }

    /**
     * Creates a new "AND WHERE" condition for the query.
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function andWhere($column, $op, $value)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'andWhere',
            'args' => [$column, $op, $value],
        ];

        return $this;
    }

    /**
     * Creates a new "OR WHERE" condition for the query.
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function orWhere($column, $op, $value)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'orWhere',
            'args' => [$column, $op, $value],
        ];

        return $this;
    }

    /**
     * Alias of andWhereOpen()
     *
     * @return  $this
     */
    public function whereOpen()
    {
        return $this->andWhereOpen();
    }

    /**
     * Opens a new "AND WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function andWhereOpen()
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'andWhereOpen',
            'args' => [],
        ];

        return $this;
    }

    /**
     * Opens a new "OR WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function orWhereOpen()
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'orWhereOpen',
            'args' => [],
        ];

        return $this;
    }

    /**
     * Closes an open "AND WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function whereClose()
    {
        return $this->andWhereClose();
    }

    /**
     * Closes an open "AND WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function andWhereClose()
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'andWhereClose',
            'args' => [],
        ];

        return $this;
    }

    /**
     * Closes an open "OR WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function orWhereClose()
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'orWhereClose',
            'args' => [],
        ];

        return $this;
    }

    /**
     * Applies sorting with "ORDER BY ..."
     *
     * @param   mixed   $column     column name or array($column, $alias) or object
     * @param   string  $direction  direction of sorting
     * @return  $this
     */
    public function orderBy($column, $direction = null)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'orderBy',
            'args' => [$column, $direction],
        ];

        return $this;
    }

    /**
     * Return up to "LIMIT ..." results
     *
     * @param   integer  $number  maximum results to return
     * @return  $this
     */
    public function limit($number)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'limit',
            'args' => [$number],
        ];

        return $this;
    }

    /**
     * Enables or disables selecting only unique columns using "SELECT DISTINCT"
     *
     * @param   boolean  $value  enable or disable distinct columns
     * @return  $this
     */
    public function distinct($value)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'distinct',
            'args' => [$value],
        ];

        return $this;
    }

    /**
     * Choose the columns to select from.
     *
     * @param   mixed  $columns  column name or array($column, $alias) or object
     * @param   ...
     * @return  $this
     */
    public function select($columns = null)
    {
        $columns = func_get_args();

        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'select',
            'args' => $columns,
        ];

        return $this;
    }

    /**
     * Choose the tables to select "FROM ..."
     *
     * @param   mixed  $tables  table name or array($table, $alias) or object
     * @param   ...
     * @return  $this
     */
    public function from($tables)
    {
        $tables = func_get_args();

        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'from',
            'args' => $tables,
        ];

        return $this;
    }

    /**
     * Adds addition tables to "JOIN ...".
     *
     * @param   mixed   $table  column name or array($column, $alias) or object
     * @param   string  $type   join type (LEFT, RIGHT, INNER, etc)
     * @return  $this
     */
    public function join($table, $type = null)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'join',
            'args' => [$table, $type],
        ];

        return $this;
    }

    /**
     * Adds "ON ..." conditions for the last created JOIN statement.
     *
     * @param   mixed   $c1  column name or array($column, $alias) or object
     * @param   string  $op  logic operator
     * @param   mixed   $c2  column name or array($column, $alias) or object
     * @return  $this
     */
    public function on($c1, $op, $c2)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'on',
            'args' => [$c1, $op, $c2],
        ];

        return $this;
    }

    /**
     * Creates a "GROUP BY ..." filter.
     *
     * @param   mixed   $columns  column name or array($column, $alias) or object
     * @param   ...
     * @return  $this
     */
    public function groupBy($columns)
    {
        $columns = func_get_args();

        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'groupBy',
            'args' => $columns,
        ];

        return $this;
    }

    /**
     * Alias of andHaving()
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function having($column, $op, $value = null)
    {
        return $this->andHaving($column, $op, $value);
    }

    /**
     * Creates a new "AND HAVING" condition for the query.
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function andHaving($column, $op, $value = null)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'andHaving',
            'args' => [$column, $op, $value],
        ];

        return $this;
    }

    /**
     * Creates a new "OR HAVING" condition for the query.
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function orHaving($column, $op, $value = null)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'orHaving',
            'args' => [$column, $op, $value],
        ];

        return $this;
    }

    /**
     * Alias of andHavingOpen()
     *
     * @return  $this
     */
    public function havingOpen()
    {
        return $this->andHavingOpen();
    }

    /**
     * Opens a new "AND HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function andHavingOpen()
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'andHavingOpen',
            'args' => [],
        ];

        return $this;
    }

    /**
     * Opens a new "OR HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function orHavingOpen()
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'orHavingOpen',
            'args' => [],
        ];

        return $this;
    }

    /**
     * Closes an open "AND HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function havingClose()
    {
        return $this->andHavingClose();
    }

    /**
     * Closes an open "AND HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function andHavingClose()
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'andHavingClose',
            'args' => [],
        ];

        return $this;
    }

    /**
     * Closes an open "OR HAVING (...)" grouping.
     *
     * @return  $this
     */
    public function orHavingClose()
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'orHavingClose',
            'args' => [],
        ];

        return $this;
    }

    /**
     * Start returning results after "OFFSET ..."
     *
     * @param   integer   $number  starting result number
     * @return  $this
     */
    public function offset($number)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'offset',
            'args' => [$number],
        ];

        return $this;
    }

    /**
     * Enables the query to be cached for a specified amount of time.
     *
     * @param   integer  $lifetime  number of seconds to cache
     * @return  $this
     */
    public function cached($lifetime = null)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'cached',
            'args' => [$lifetime],
        ];

        return $this;
    }

    /**
     * Set the value of a parameter in the query.
     *
     * @param   string   $param  parameter key to replace
     * @param   mixed    $value  value to use
     * @return  $this
     */
    public function setParam($param, $value)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'setParam',
            'args' => [$param, $value],
        ];

        return $this;
    }

    /**
     * Adds "USING ..." conditions for the last created JOIN statement.
     *
     * @param   string  $columns  column name
     * @return  $this
     */
    public function using($columns)
    {
        // Add pending database call which is executed after query type is determined
        $this->db_pending[] = [
            'name' => 'using',
            'args' => [$columns],
        ];

        return $this;
    }

    /**
     * Checks whether a column value is unique.
     * Excludes itself if loaded.
     *
     * @param   string   $field  the field to check for uniqueness
     * @param   mixed    $value  the value to check for uniqueness
     * @return  bool     whteher the value is unique
     */
    public function unique($field, $value)
    {
        $model_class = $this->getObjectName() . 'Model';
        
        $model = (new $model_class())
                ->where($field, '=', $value)
                ->find();

        if ($this->isLoaded()) {
            return (!($model->isLoaded() AND $model->pk() != $this->pk()));
        }

        return (!$model->isLoaded());
    }

}
