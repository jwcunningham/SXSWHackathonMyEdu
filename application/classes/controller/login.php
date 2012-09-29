<?php defined('SYSPATH') OR die('No Direct Script Access');
 
Class Controller_login extends Controller_Template
{
    public $template = 'login';
 
    public function action_index()
    {
        $this->template->message = 'This is the login page';
    }
}


