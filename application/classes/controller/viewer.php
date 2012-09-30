<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Viewer extends Controller_Template {

	public $template = 'viewer';

	public function action_index()
	{
		$p = array();
		$this->template->patients = $p;

	}

}
