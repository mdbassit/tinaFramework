<?php
/**
 * The request class that handles various HTTP request tasks.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

// No direct access.
defined('tinaFramework') or die; 

 
class Request 
{
    /**
     * Set a variable in the appropriate special vars array based on the request method.
     * 
     * @param string $var the name of the variable.
     * @param string $value the value of the variable.
     * @param string $method the HTTP request method.
     * @return void.
     */
    public function setVar($var, $value, $method = null) 
    {
        $_REQUEST[$var] = $value;
        
        switch($method) {
            case 'post':
                $_POST[$var] = $value;
                break;
            default:
                $_GET[$var] = $value;
        }
        
    }
    
    /**
     * Get a variable from the appropriate special vars array based on the request method.
     * 
     * @param string $var the name of the variable.
     * @param string $method the HTTP request method.
     * @return mixed the value of variable.
     */
    public function getVar($var, $method = null) 
    {
        $vars = $this->getVars($method);
        
        return $vars[$var];
    }
    
    /**
     * Get the appropriate special vars array based on the request method.
     * 
     * @param string $method the HTTP request method.
     * @return array the special vars array.
     */
    public function getVars($method = null) 
    {
        switch($method) {
            case 'post':
                return $_POST;
            case 'get':
                return $_GET;
            default:
                return $_REQUEST;
        }
        
    }
    
    /**
     * Fetch a given uploaded file and return its data as an object.
     * 
     * @param string $var the file name.
     * @return object the file data.
     */
    public function getFile($var) 
    {
        $file = new stdClass();
        $file->name = $_FILES[$var]['name'];
        $file->type = $_FILES[$var]['type'];
        $file->tmp_name = $_FILES[$var]['tmp_name'];
        $file->error = $_FILES[$var]['error'];
        $file->size = $_FILES[$var]['size'];
        
        return $file;
    }
    
    /**
     * Get the appropriate view name based on the requested view.
     * 
     * @return string the view name.
     */
	public function getView($default = 'home')
	{   
        $view = ($this->getVar('view') != '') ? $this->getVar('view') : $default;
        
        // Protect against potential Remote File Inclusion (RFI) and Local File Inclusion (LFI) vulnerabilities
        $view = preg_replace("/\\\|\/|\:|\*|\?|\"|\<|\>|\.|\|/", "", $view);
        
        if (!file_exists(ROOT_DIR . '/controller/' . $view . '.php')) {
            die('Error 404 - Page Not Found');
        }
        
        return $view;
	}
    
    /**
     * Get the appropriate action name based on the requested action.
     * 
     * @return string the action name.
     */
    public function getAction()
	{   
        $requestedAction = $this->getVar('action');
        $action = ($requestedAction != '') ? $requestedAction : 'display';
        
        return $action;
	}
    
    /**
     * Get the application host URL.
     * 
     * @return string the host URL.
     */
    public function getHost() 
    {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];

        return $protocol . $host;
    }
    
    /**
     * Get the application base URL.
     * 
     * @return string the base URL.
     */
    public function getBaseURL() 
    {
        $host = $this->getHost();
        $path = pathinfo($_SERVER['PHP_SELF']);
        $uri = $path['dirname'];
        
        $uri = ($uri == '/') ? '' : $uri;

        return $host . $uri;
    }
    
    /**
     * Get the application URL.
     * 
     * @param boolean $queryString if set to true, include the query string in the URL.
     * @return string the URL.
     */
    public function getURL($queryString = true) 
    {
        $host = $this->getHost();
        $uri = $_SERVER['REQUEST_URI'];
        
        if (!$queryString) $uri = strtok($uri, '?');

        return $host . $uri;
    }
    
    /**
     * Redirect to the requested URL and set a message if any.
     * 
     * @param string $url the url to redirect to.
     * @param string $message an optional message to display after the redirection.
     * @param string $type of the message (usually information or warning).
     * @return void.
     */
    public function redirect($url, $message = '', $type = 'information') 
    {
        if ($message != '') {
            $session = new Session();
            $session->setMessage($message, $type);
        }
        
        header('Location: ' . $url);
    }
}
