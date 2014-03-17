<?php
/**
 * Loads the configuration file and classes needed by tinaFramework.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */
 
// No direct access.
defined('tinaFramework') or die;

// Set error reporting type
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Include the configuration file
require_once ROOT_DIR . '/config.php';

// If a template is not set, use default
defined('DEFAULT_TEMPLATE') or define('DEFAULT_TEMPLATE', 'default');

// Start the session
session_start();

// Include the needed classes
require_once ROOT_DIR . '/include/database.php';
require_once ROOT_DIR . '/include/controller.php';
require_once ROOT_DIR . '/include/model.php';
require_once ROOT_DIR . '/include/session.php';
require_once ROOT_DIR . '/include/request.php';

// TODO : Implement a class autoloader
