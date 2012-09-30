<?php
class Controller_Services_Studies extends Controller_Services {
    public function action_get() {
        $studies = ORM::factory('study');
        $studies = $studies->find_all()->as_array();
       # die(print_r($patients,1));
        $p = array();
        foreach($studies as $k => $p_) array_push($p, $p_->as_array());
        $this->data = $p;
    }
}
