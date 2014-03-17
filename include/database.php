<?php
/**
 * Load the database object.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */
 
// No direct access.
defined('tinaFramework') or die;
 

class Database 
{
    /**
     * Get the appropriate database object based on the provided type.
     * 
     * @return object the database object.
     */
    public static function getDB() 
    {        
        // If a database type is not set, default to Mysqli
        defined('DB_TYPE') or define('DB_TYPE', 'mysqli');
        
        // Load the appropriate database class
        require_once dirname(__FILE__) . '/database/' . DB_TYPE . '.php';
        
        // Initialize the database instance
        $dbClass = ucfirst(DB_TYPE) . 'DB';
        $dbObject = new $dbClass();
        
        return $dbObject;
    }
}
