<?php
class Controller_Services_Series extends Controller_Services {
    public function action_get() {
        $series = ORM::factory('series');
        $l = $this->limit;
        $o = $this->offset;
	if (isset($_GET['study_key'])) {
		$series = $series->where('study_key','=', $_GET['study_key'])->limit($l)->offset($o)->find_all()->as_array();
	} else {
	        $series = $series->->limit($l)->offset($o)->find_all()->as_array();
	}
        $p = array();
        foreach($series as $k => $p_) {
            $s = $p_->as_array();
            $images = array();
            foreach(DB::select()->from('image')
                ->where('series_key', '=', $p_->series_key)->execute()->as_array() as $ik => $i)
                    $images[] = $i;
            $s['images'] = $images;
            array_push($p, $s);
        }
        $this->data = $p;
    }
}
