<?php
/**
 * Define an abstract database class to be extended by all database objects.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

// No direct access.
defined('tinaFramework') or die;


abstract class DB 
{
    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;
    protected $link;
    
    /**
     * The constructor sets the configuration variables required to establish
     * a database connection.
     * 
     * @return void.
     */
    public function __construct() 
    {
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;
    }
    
    /**
     * Establish a connection to the database server and select a database.
     * 
     * @return void.
     */
    abstract protected function connect();
    
    /**
     * Return a database specific query error number if any.
     * 
     * @return integer the error number.
     */
    abstract protected function errno();
    
    /**
     * Return a database specific query error if any.
     * 
     * @return string the error message.
     */
    abstract protected function error();
    
    /**
     * Execute a query.
     * 
     * @param string $query the SQL query.
     * @param array $params the params to prepare the query.
     * @param string $types the query params types.
     * @return mixed true or false or the query resultset.
     */
    abstract protected function query($query, $params = null, $types = null);
    
    /**
     * Fetch a result row as an object.
     * 
     * @param mixed $result the query resultset.
     * @return object the result row.
     */
    abstract protected function getObject($result);
    
    /**
     * Fetch result rows as an array of objects.
     * 
     * @param mixed $result the query resultset.
     * @return array the result rows.
     */
    abstract protected function getObjectList($result);
    
    /**
     * Get the id of the last insert query.
     * 
     * @return integer the last insert id.
     */
    abstract protected function getId();
    
    /**
     * Get the number of rows in result.
     * 
     * @param mixed $result the query resultset.
     * @return integer the number of rows.
     */
    abstract protected function numRows($result);
    
    /**
     * Close the database connection.
     * 
     * @return void.
     */
    abstract protected function close();
}
