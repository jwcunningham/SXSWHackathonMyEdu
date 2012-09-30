<?php defined('SYSPATH') OR die('No Direct Script Access');
 
Class Controller_Auth extends Controller_Template
{
    public $template = 'login';
 
    public function action_index()
    {
        $this->template->message = 'This is the login page';
    }


    public function action_login()
    {
	$username = $_POST['username'];
	$password = $_POST['password'];
        $auth = new Auth_file();
        return $auth->_login($username,$password,FALSE);
    }
}


