<?php
namespace Libraries;
class Stats {
var $vars;

	function pullStats($set){


		$terms = '';
		$cacheDir = '../xmlcache/';
		if( file_exists($cacheDir.$set.'.xml') ){
			$xml = simplexml_load_file($cacheDir.$set.'.xml');
		}
		// transform the XML into HTML using the XSL file
		var_dump($xml->terms);
			$temp_hards = array();
			$temp_easies = array();
			
			
			/*
foreach($stats_xml->easy as $easy){
				array_push($temp_easies, array('name'=> (string)$easy->name, 'counter'=> (string)$easy->counter) );
			}
			foreach($stats_xml->hard as $hard){
				array_push($temp_hards, array('name'=> (string)$hard->name, 'counter'=> (string)$hard->counter) );
			}
*/
			//$temp_return = array('hards'=>$temp_hards, 'easies'=>$temp_easies, 'total'=>(string)$stats_xml->total, 'title'=>(string)$stats_xml->title, 'description'=>(string)$stats_xml->description, 'answers'=>(string)$stats_xml->answers);

			//return $temp_return;

	}
}
