<?php
class Controller_Services_Series extends Controller_Services {
    public function action_get() {
        $series = ORM::factory('series');
        $series = $series->find_all()->as_array();
       # die(print_r($patients,1));
        $p = array();
        foreach($series as $k => $p_) array_push($p, $p_->as_array());
        $this->data = $p;
    }
}
