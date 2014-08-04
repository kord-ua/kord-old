<?php

/**
 * Provides a shortcut to get Database related objects for [making queries](../database/query).
 *
 * Shortcut     | Returned Object
 * -------------|---------------
 * [`\KORD\DB::query()`](#query)   | [\KORD\Database\Query]
 * [`\KORD\DB::insert()`](#insert) | [\KORD\Database\QueryBuilder\Insert]
 * [`\KORD\DB::select()`](#select),<br />[`\KORD\DB::selectArray()`](#select_array) | [\KORD\Database\QueryBuilder\Select]
 * [`\KORD\DB::update()`](#update) | [\KORD\Database\QueryBuilder\Update]
 * [`\KORD\DB::delete()`](#delete) | [\KORD\Database\QueryBuilder\Delete]
 * [`\KORD\DB::expr()`](#expr)     | [\KORD\Database\Expression]
 *
 * You pass the same parameters to these functions as you pass to the objects they return.
 * 
 * @copyright  (c) 2007–2014 Kohana Team
 */

namespace KORD;

class DBSrc
{

    /**
     * Create a new [\KORD\Database\Query] of the given type.
     *
     *     // Create a new SELECT query
     *     $query = \KORD\DB::query(\KORD\Database::SELECT, 'SELECT * FROM users');
     *
     *     // Create a new DELETE query
     *     $query = \KORD\DB::query(\KORD\Database::DELETE, 'DELETE FROM users WHERE id = 5');
     *
     * Specifying the type changes the returned result. When using
     * `\KORD\Database::SELECT`, a [\KORD\Database\Result] will be returned.
     * `Database::INSERT` queries will return the insert id and number of rows.
     * For all other queries, the number of affected rows is returned.
     *
     * @param   integer  $type  type: \KORD\Database::SELECT, \KORD\Database::UPDATE, etc
     * @param   string   $sql   SQL statement
     * @return  \KORD\Database\Query
     */
    public static function query($type, $sql)
    {
        return new \KORD\Database\Query($type, $sql);
    }

    /**
     * Create a new [\KORD\Database\QueryBuilder\Select]. Each argument will be
     * treated as a column. To generate a `foo AS bar` alias, use an array.
     *
     *     // SELECT id, username
     *     $query = \KORD\DB::select('id', 'username');
     *
     *     // SELECT id AS user_id
     *     $query = \KORD\DB::select(['id', 'user_id']);
     *
     * @param   mixed   $columns  column name or array($column, $alias) or object
     * @return  \KORD\Database\QueryBuilder\Select
     */
    public static function select($columns = null)
    {
        return new \KORD\Database\QueryBuilder\Select(func_get_args());
    }

    /**
     * Create a new [\KORD\Database\QueryBuilder\Select] from an array of columns.
     *
     *     // SELECT id, username
     *     $query = \KORD\DB::selectArray(['id', 'username']);
     *
     * @param   array   $columns  columns to select
     * @return  \KORD\Database\QueryBuilder\Select
     */
    public static function selectArray(array $columns = null)
    {
        return new \KORD\Database\QueryBuilder\Select($columns);
    }

    /**
     * Create a new [\KORD\Database\QueryBuilder\Insert].
     *
     *     // INSERT INTO users (id, username)
     *     $query = \KORD\DB::insert('users', ['id', 'username']);
     *
     * @param   string  $table    table to insert into
     * @param   array   $columns  list of column names or array($column, $alias) or object
     * @return  \KORD\Database\QueryBuilder\Insert
     */
    public static function insert($table = null, array $columns = null)
    {
        return new \KORD\Database\QueryBuilder\Insert($table, $columns);
    }

    /**
     * Create a new [\KORD\Database\QueryBuilder\Update].
     *
     *     // UPDATE users
     *     $query = \KORD\DB::update('users');
     *
     * @param   string  $table  table to update
     * @return  \KORD\Database\QueryBuilder\Update
     */
    public static function update($table = null)
    {
        return new \KORD\Database\QueryBuilder\Update($table);
    }

    /**
     * Create a new [\KORD\Database\QueryBuilder\Delete].
     *
     *     // DELETE FROM users
     *     $query = \KORD\DB::delete('users');
     *
     * @param   string  $table  table to delete from
     * @return  \KORD\Database\QueryBuilder\Delete
     */
    public static function delete($table = null)
    {
        return new \KORD\Database\QueryBuilder\Delete($table);
    }

    /**
     * Create a new [\KORD\Database\Expression] which is not escaped. An expression
     * is the only way to use SQL functions within query builders.
     *
     *     $expression = \KORD\DB::expr('COUNT(users.id)');
     *     $query = \KORD\DB::update('users')->set(['login_count' => \KORD\DB::expr('login_count + 1')])->where('id', '=', $id);
     *     $users = \KORD\ORM::factory('user')->where(\KORD\DB::expr("BINARY `hash`"), '=', $hash)->find();
     *
     * @param   string  $string  expression
     * @param   array   parameters
     * @return  \KORD\Database\Expression
     */
    public static function expr($string, $parameters = [])
    {
        return new \KORD\Database\Expression($string, $parameters);
    }

}
