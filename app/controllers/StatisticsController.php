<?php

class StatisticsController extends BaseController {

	public function index($id){
		$stats = new \Libraries\Stats;
		$data['stats']= $stats->pullStats($id);
		return View::make('stats', $data);
	}

}