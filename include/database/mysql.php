<?php
/**
 * The MySql specific database object.
 *
 * @author		Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright	Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

// No direct access.
defined('tinaFramework') or die;


require_once dirname(__FILE__) . '/db.php';

class MysqlDB extends DB 
{
    private $new_link = true;
    private $client_flags = 0;
   
    public function __construct() 
    {
        parent::__construct();
        $this->connect();
    }
   
    public function __destruct() 
    {
        $this->close();
    }

    /**
     * Establish a connection to the database server and select a database.
     * 
     * @return void.
     */
    public function connect() 
    {
        $this->link = mysql_connect($this->host, $this->user, $this->pass, $this->new_link, $this->client_flags);
        if (!$this->link) {
            die('Database connection failed: ' . $this->error());
        }
        
        mysql_set_charset('utf8', $this->link);
        mysql_select_db($this->dbname, $this->link);
    }
    
    /**
     * Return a database specific query error number if any.
     * 
     * @return integer the error number.
     */
    public function errno() 
    {
        return mysql_errno($this->link);
    }
    
    /**
     * Return a database specific query error if any.
     * 
     * @return string the error message.
     */
    public function error() 
    {
        return mysql_error($this->link);
    }
    
    /**
     * Execute a query.
     * 
     * @param string $query the SQL query.
     * @param array $params the params to prepare the query.
     * @param string $types the query params types.
     * @return mixed true or false or the query resultset.
     */
    public function query($query, $params = null, $types = null) 
    {
        //Implement prepare emulation
        $guesstype = false;
        if ($params != null) {
            if ($types == null) {
                $types = '';
                $guesstype = true;
            }
            foreach ($params as $param) {
                if ($guesstype) $types .= $this->getBindType(gettype($param));
                $query = preg_replace("/(?<!['\"])(\\?)(?!['\"])/", $this->escapeString($param), $query, 1);
            }
        }
        
        $result = mysql_query($query, $this->link);
        if (!$result) {
            die('Invalid query: ' . $this->error());
        }
        
        return $result;
    }
    
    /**
     * Fetch a result row as an object.
     * 
     * @param mixed $result the query resultset.
     * @return object the result row.
     */
    public function getObject($result)  
    {
        return mysql_fetch_object($result);
    }
    
    /**
     * Fetch result rows as an array of objects.
     * 
     * @param mixed $result the query resultset.
     * @return array the result rows.
     */
    public function getObjectList($result)  
    {
        $list = array();
        $i = 0;
        
        while ($obj = mysql_fetch_object($result)) {
            $obj->_index = $i;
            array_push($list, $obj);
            $i++;
        }
        
        mysql_free_result($result);
        
        return $list;
    }
    
    /**
     * Get the id of the last insert query.
     * 
     * @return integer the last insert id.
     */
    public function getId()  
    {
        return mysql_insert_id($this->link);
    }
    
    /**
     * Get the number of rows in result.
     * 
     * @param mixed $result the query resultset.
     * @return integer the number of rows.
     */
    public function numRows($result) 
    {
        return mysql_num_rows($result);
    }
    
    /**
     * Close the database connection.
     * 
     * @return void.
     */
    public function close() 
    {
        return mysql_close($this->link);
    }
    
    /**
     * Escape strings before appending them to to query to help protect 
     * against SQL injection attacks.
     * 
     * @param string $str the string to escape.
     * @return string the escaped string.
     */
    public function escapeString($str)
    {
        // Stripslashes
        if (get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        
        // Quote if a string
        if (is_string($str))
        {
             $str = "'" . mysql_real_escape_string($str, $this->link) . "'";
        }
        
        return $str;
    }
    
    /**
     * Get the correct bind type of a query param based on it's actual data type.
     * 
     * @param string $type the data type.
     * @return string the bind type.
     */
    public function getBindType($type)
    {
        switch ($type) {
            case 'integer':
                $bindType = 'i';
                break;
            case 'double':
                $bindType = 'd';
                break;
            default:
                $bindType = 's';
        }
        
        return $bindType;
    }
}

