<?php
class Base {
	var $vars;
	var $cacheDir = 'xmlcache/';
	function storeAnswers($answers){
		foreach ($answers as $answer){
			$index = (int)$answer['index'];
			$correct = $answer['correct'];
			$slow = $answer['slow'];
			//If correct, increment the counter for that term
			if($correct =='false'){
				--$this->vars['terms_xml']->term[$index]->counter;
			}

			else{
				++$this->vars['terms_xml']->term[$index]->counter;
			}


		}
		$this->vars['set_xml']->asXML('xmlcache/'.$this->vars['set'].'.xml');
	}
	function pickSet($id){
		$this->vars['set'] = $id;
		$cacheDir = 'xmlcache/';
		if( file_exists($cacheDir.$this->vars['set'].'.xml') ){
			$set_xml = simplexml_load_file($cacheDir.$this->vars['set'].'.xml');
			$this->vars['set_xml'] = $set_xml;
			return true;
		}
		else{


			$ch = curl_init('https://api.quizlet.com/2.0/sets/'.$this->vars['set'].'?client_id=kyM6yER822&whitespace=1');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$res = curl_exec($ch);
			curl_close($ch);
			if($ch){

			}

			if ( $json = json_decode($res) ) {
				$terms= $json->terms;
			}
			else{
				throw new Exception("Couldn't fetch the set");
				return false;
			}

			$xmlstr = "<?xml version='1.0' ?><set><details></details><terms></terms></set>";
			$set_xml = new SimpleXMLElement($xmlstr);
			$title_xml = $set_xml->details->addChild('title');
			$description_xml = $set_xml->details->addChild('description');
			$set_xml->details->title = (string)$json->title;
			$set_xml->details->description = (string)$json->description;
			foreach ($terms as $term) {
				$term_xml = $set_xml->terms->addChild('term');
				$term_name_xml = $term_xml->addChild('name');
				$definition_xml = $term_xml->addChild('definition');
				$counter_xml = $term_xml->addChild('counter');
				$term_xml->name = htmlspecialchars((string)$term->term);
				$term_xml->definition = htmlspecialchars((string)$term->definition);
				$term_xml->counter = 0;
			}
			$set_xml->asXML($cacheDir.$this->vars['set'].'.xml');
			$this->vars['set_xml'] = $set_xml;

			return true;

		}
	}
	function setVars($id){

		$this->pickSet($id);
		$this->vars['terms_xml'] = $this->vars['set_xml']->terms;
		$this->vars['number_of_terms'] = $this->vars['terms_xml']->term->count() - 1;
		$this->vars['set_title'] = $this->vars['set_xml']->details->title;
		$this->vars['set_description'] = $this->vars['set_xml']->details->description;

		/* $this->vars['set_counter_average'] = $this->vars['set_xml']->details->description; */
		return $this->vars;
	}
}
?>