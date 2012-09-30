<?php
class Controller_Services_Image extends Controller_Services {
    public function action_get() {
        $image = ORM::factory('image');
	
	if (isset($_GET['series_key'])) {
		$image = $image->where('series_key', '=', $_GET['series_key'])->find_all()->as_array();
	} else {
        	$image = $image->find_all(1000)->as_array();
	}
       # die(print_r($patients,1));
        $p = array();
        foreach($image as $k => $p_) array_push($p, $p_->as_array());
        $this->data = $p;
    }
}
