<?php
/**
 * This is the external class loader.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

// No direct access.
defined('tinaFramework') or die;

 
class ExternalClass 
{    
    /**
     * Load an external class.
     * 
     * @return object.
     */
    public function load($classname, $file, $namespace = null)
    {
        require_once ROOT_DIR . '/external/' . $classname . '/' . $file;
        
        if ($namespace != null) $classname = '\\' . $namespace . '\\' . $classname;
        $classObject = new $classname();
        
        return $classObject;
    }
    
    /**
     * Require an external file.
     * 
     * @return void.
     */
    public function loadFile($libname, $file)
    {
        require_once ROOT_DIR . '/external/' . $libname . '/' . $file;
    }
}
