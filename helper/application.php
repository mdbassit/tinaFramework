<?php
/**
 * The application helper that handles various input, output and session tasks.
 *
 * @author     Mohammed Bassit <m.bassit@e-learningdesign.com>
 * @copyright  Copyright (C) 2008-2014 author and Learning Design SARL, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */
 
class ApplicationHelper 
{
    /**
     * Get logged in user data.
     * 
     * @return object the user data.
     */
    public function getUser()
	{   
        $session = new Session();
        $user = new stdClass();
        $user->id = '';
        
        if ($session->get('user') != null) {
            $user = $session->get('user');
        }
        
        return $user;
	}
    
    /**
     * Redirect the user to the login page.
     * 
     * @param string $view the current view.
     * @return void.
     */
    public function requireLogin($view)
	{   
        $request = new Request();
        $session = new Session();
        $user = $this->getUser();
        
        if (($user->id == '') && ($view != 'login')) {
            
            $return = $request->getURL();
            if (preg_match("/action=delete/", $return)) $return = '';
            
            if ($return != '') $session->set('return', $return);
            
            $request->redirect('index.php?view=login');
            exit;
        }
	}
    
    /**
     * GET the user's IP address.
     * 
     * @return string the user's IP address.
     */
    public function getIpAddress() 
    {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            
        return $ipaddress;
    }
    
    /**
     * Send a plain text UTF8 email.
     * 
     * @param string $from the sender's identity.
     * @param string $to the recipient email address.
     * @param string $subject the subject of the email.
     * @param string $message the message.
     * @param string $header additional headers to append to the default ones.
     * @return void.
     */
    public function sendmail($from, $to, $subject = '(No subject)', $message = '', $header = '') 
    {
        $headers = 'From: ' . $from . "\r\n". 
                   'MIME-Version: 1.0' . "\r\n" . 
                   'Content-type: text/plain; charset=UTF-8' . "\r\n"  . 
                   'X-Mailer: PHP/' . phpversion();
        
        mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header . $headers);
    }
}
