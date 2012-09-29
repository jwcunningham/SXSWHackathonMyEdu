<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller {

	public function action_index()
	{
		$this->response->body('This is the login page.');
	}

} // End Welcome
