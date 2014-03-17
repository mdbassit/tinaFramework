<?php
/**
 * The default controller that the other controllers will extend.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

// No direct access.
defined('tinaFramework') or die;


class Controller 
{
    private $vars = array();
    
    
    /**
     * Load the appropriate controller based on the requested view.
     * 
     * @param string $view the name of the view.
     * @return object the controller object.
     */
    public static function load($view)
    {
        require_once ROOT_DIR . '/controller/' . $view . '.php';
        
        $controllerClass = $view . 'Controller';
        $controllerObject = new $controllerClass();
        
        return $controllerObject;
    }
    
    /**
     * Saves the variables to assign to the view.
     * 
     * @param string $name the variable name.
     * @param mixed $value the variable value.
     * @return void.
     */
    public function assign($name, $value)
    {
        $this->vars[$name] = $value;
    }
    
    /**
     * Displays the view and the template.
     * 
     * @param string $view the name of the view.
     * @param boolean $template if set to true, also display the template.
     * @return void.
     */
    public function displayView($view, $template = true)
    {
        $session = new Session();
        $pageTitle = $this->getViewTitle($view);
        $systemMessage = '';
        
        // Assign the variables to the view
        foreach ($this->vars as $key => $value)
        {
            $$key = $value;
        }
        
        // If there is a system message to display, assign it to the view
        if ($session->getMessage() != null) {
            $message = $session->getMessage();
            // Is there a better way to to this ?
            $systemMessage = '<span class="' . $message->type . '">' . $message->content . '</span>';
            $session->clearMessage();
        }
        
        // Display the view, and optionally the template
        if ($template) include ROOT_DIR . '/template/' . DEFAULT_TEMPLATE . '/header.php';
        include ROOT_DIR . '/view/' . $view . '.php';
        if ($template) include ROOT_DIR . '/template/' . DEFAULT_TEMPLATE . '/footer.php';
    }
    
    /**
     * Get the requested model.
     * 
     * @param string $model the name of the model.
     * @return object the model object.
     */
    public function getModel($model)
    {
        require_once ROOT_DIR . '/model/' . $model . '.php';
        
        $modelClass = $model . 'Model';
        $modelObject = new $modelClass();
        
        return $modelObject;
    }
    
    /**
     * Get title of the view.
     * 
     * @param string $view the name of the view.
     * @return string the title of the view.
     */
    public function getViewTitle($view)
    {
        $viewNames = parse_ini_file(ROOT_DIR . '/view/views.ini');
        
        return $viewNames[$view];
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
        $request = new Request();
        $request->redirect($url, $message, $type);
    }
}

