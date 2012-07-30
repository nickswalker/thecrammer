<?php
class Crammer
{			
	function initialize(){
	/*
		$ch = curl_init('https://api.quizlet.com/2.0/sets/12226611?access_token=NGY0M2U2NjRiYTMyYzZmYmYzYmQwMDBkYjY4NzFm&whitespace=1');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
*/
		$res= file_get_contents('set.json');

		if ( $json = json_decode($res) ) {
			$terms= $json->terms;
		}
		
		if(file_exists('store.xml')){
			$terms_xml = simplexml_load_file('store.xml');
		}
		else{	
		
			$xmlstr = "<?xml version='1.0' ?><terms></terms>";
			$terms_xml = new SimpleXMLElement($xmlstr);
			foreach ($terms as $term) {
				$term_xml = $terms_xml->addChild('term');
				$term_name_xml = $term_xml->addChild('name');
				$definition_xml = $term_xml->addChild('definition');

				$term_xml->name = (string)$term->term;
				$term_xml->definition = (string)$term->definition;

			}
			$terms_xml->asXML('store.xml');
		
		}
		$this->vars['number_of_terms'] = $terms_xml->term->count();
		$this->vars['correct_index'] =  rand(0,$this->vars['number_of_terms']);
		$this->vars['incorrect_index'] =  rand(0,$this->vars['number_of_terms']);
		$this->vars['test_term'] = $terms_xml->term[$this->vars['correct_index']];
		$this->vars['test_term_name'] = (string)$this->vars['test_term']->name;
		$this->vars['correct_definition'] = (string)$this->vars['test_term']->definition;
		$this->vars['incorrect_term'] = $terms_xml->term[$this->vars['incorrect_index']];
		$this->vars['incorrect_definition'] = (string)$this->vars['incorrect_term']->definition;
		print_r($this->vars);
	}
	function showTest(){
		
		echo( $this->vars['test_term_name'].$this->vars['correct_definition'].$this->vars['incorrect_definition']);
	}
}
?>
