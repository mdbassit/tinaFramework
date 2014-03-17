<?php
/**
 * The session class handles various session tasks.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

// No direct access.
defined('tinaFramework') or die;

 
class Session 
{
    /**
     * Set a variable in the current session.
     * 
     * @param string $var the name of the variable.
     * @param string $value the value of the variable.
     * @return void.
     */
    public function set($var, $value) 
    {
        $_SESSION[$var] = $value;
    }
    
    /**
     * Get a variable from the current session.
     * 
     * @param string $var the name of the variable.
     * @return mixed the value of variable.
     */
    public function get($var) 
    {
        return $_SESSION[$var];
    }
    
    /**
     * Save the form data in the session as an object.
     * 
     * @return void.
     */
    public function saveSessionData($data, $type = 'object')
	{   
        if ($type == 'object') {
            $object = new stdClass();
            
            foreach($data as $key=>$value) {
                $object->$key = $value;
            }
        } else {
            $object = $data;
        }
        
        $this->set('_data', $object);
	}
    
    /**
     * get the saved form data from the session.
     * 
     * @return object the from data.
     */
    public function getSessionData($type = 'object')
	{   
        if ($type == 'object') {
            $object = new stdClass();
        } else {
            $object = array();
        }
        
        if ($this->get('_data') != null) $object = $this->get('_data');
        
        return $object;
	}
    
    /**
     * Clear session data.
     * 
     * @return void.
     */
    public function clearSessionData()
	{   
        $this->set('_data', null);
	}
    
    /**
     * Get a confirmation or error message that is saved in the session.
     * 
     * @return object the message data.
     */
    public function getMessage()
	{   
        return $this->get('_message');
	}
    
    /**
     * Save a confirmation or error message in the session.
     * 
     * @param string $message an optional message to display after the redirection.
     * @param string $type of the message (usually information or warning).
     * @return void.
     */
    public function setMessage($message, $type)
	{   
        $object = new stdClass();
        $object->content = $message;
        $object->type = $type;
        
        $this->set('_message', $object);
	}
    
    /**
     * Clear the confirmation or error message that is saved in the session.
     * 
     * @return void.
     */
    public function clearMessage()
	{   
        $this->set('_message', null);
	}
}
