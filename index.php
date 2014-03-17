<?php
/**
 * This is the index page that handles all page requests in tinaFramework.
 *
 * tinaFramework stands for This Is Not A Framework, and like its name implies,
 * it's not a full-fledged PHP framework, but rather a simple MVC skeleton I've been
 * using and enhancing for years, and now I've decided to release it to the public.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

// Constant definition
define('tinaFramework', true);
define('ROOT_DIR', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

// Include the bootstrap
require_once 'include/bootstrap.php';

// Initialize the request class
$request = new Request();

// Set the base URL
define('BASE_URL', $request->getBaseURL());

// Set the default view to people (normally it's home)
$defaultView = 'people';

// Retrieve the view and the action
$view = $request->getView($defaultView);
$action = $request->getAction();

// Initialize the controller and call the requested action
$controller = Controller::load($view);
$controller->view = $view;
$controller->$action();


// The lack of a PHP closing tag is intentional. DO NOT "FIX"!
