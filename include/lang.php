<?php
/**
 * The language and translation class.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */
 
// No direct access.
defined('tinaFramework') or die;


class Lang
{
    
    /**
     * Return the translated string in the current language if available.
     * 
     * @param string $string the text to translate.
     * @return string the translated text.
     */
    public static function _($string)
    {   
        include ROOT_DIR . DS . 'lang' . DS . DEFAULT_LANGUAGE . DS . 'strings.php';
        
        if ($strings[$string] != '') { 
            $string = $strings[$string];
        }
        
        return $string;
    }
}

