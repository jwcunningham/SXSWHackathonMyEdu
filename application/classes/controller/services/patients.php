<?php
class Controller_Services_Patients extends Controller_Services {
    public function action_get() {
        $patients = ORM::factory('patient');
        $patients = $patients->find_all()->as_array();
        $p = array();
        foreach($patients as $k => $p_) array_push($p, $p_->as_array());
        $this->data = $p;
    }
}
