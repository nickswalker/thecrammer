<?php
class Recent extends CI_Model{
var $vars;
function __construct()
    {
        parent::__construct();
    }
	function pullMostRecent($maxNumberToList = 5, $directory = 'xmlcache/', $sortOrder = "newestFirst"){
		$temp_string = '';
		$results = array();
		$handler = opendir($directory);

		while ($file = readdir($handler)) {
			if ($file != '.' && $file != '..' && $file != "robots.txt" && $file != ".htaccess"){
				$currentModified = filectime($directory."/".$file);
				$file_names[] = $file;
				$file_dates[] = $currentModified;
			}
		}
		closedir($handler);

		//Sort the date array by preferred order
		if ($sortOrder == "newestFirst"){
			arsort($file_dates);
		}else{
			asort($file_dates);
		}

		//Match file_names array to file_dates array
		$file_names_Array = array_keys($file_dates);
		foreach ($file_names_Array as $idx => $name) $name=$file_names[$name];
		$file_dates = array_merge($file_dates);

		$i = 0;

		//Loop through dates array and then echo the list
		foreach ($file_dates as $file_dates){
			$date = $file_dates;
			$j = $file_names_Array[$i];
			$file = $file_names[$j];
			$file_xml = simplexml_load_file($directory."/".$file);
			$title = (string)$file_xml->details->title;
			$description= (string)$file_xml->details->description;
			$i++;

			$temp_string .= '<li data-description="'. $description .'"><a href="/index.php?set='. substr($file , 0, -4).'&choices=4">'. $title .'</a></li>';
		}
		return $temp_string;
	}
	
}
?>