<?php
class Controller_Services_Studies extends Controller_Services {
    public function action_get() {
        $studies = ORM::factory('study');
        
        if (isset($_GET['pat_key'])) {
		$studies = $studies->where('pat_key', '=', $_GET['pat_key'])->find_all()->as_array();
	} else {
        	$studies = $studies->find_all()->as_array();
	}
        $p = array();
        foreach($studies as $k => $p_) array_push($p, $p_->as_array());
        $this->data = $p;
    }
}
