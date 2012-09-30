<?php
class Controller_Services_Image extends Controller_Services {
    public function action_get() {
        $image = ORM::factory('image');
        $image = $image->find_all()->as_array();
       # die(print_r($patients,1));
        $p = array();
        foreach($image as $k => $p_) array_push($p, $p_->as_array());
        $this->data = $p;
    }
}