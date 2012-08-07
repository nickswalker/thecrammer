<?php
class Crammer
{
	function generateQuestions($numberOfQuestions = 1, $numberOfChoices = 2){
		echo( '<div class="test"><h1 data-set="'. $this->vars['set'] .'"data-index="'.$this->vars['correct_index'].'">'.$this->vars['correct_term_name'].'</h1>'. $this->generateChoices($numberOfChoices) .'</div>');

	}
	function generateChoices($numberOfChoices = 2){

		$correctSpot = rand(1,(int)$numberOfChoices);
		for ($i = 1; $i <= $numberOfChoices; $i++) {
			if($i == $correctSpot){
				$output .= '<a class="choice" data-correct="true" href="" data-definition="'. $this->vars['correct_term_definition'] .'">'. $this->vars['correct_term_definition'] .'</a>';
			}
			else{
				$temp_incorrect_index = rand(0,$this->vars['number_of_terms']);
				if ($temp_incorrect_index == $this->vars['correct_index']){
					$temp_incorrect_index = rand(0,$this->vars['number_of_terms']);
				}
				$temp_incorrect_definition = (string)$this->vars['terms_xml']->term[$temp_incorrect_index]->definition;
				$temp_incorrect_name = (string)$this->vars['terms_xml']->term[$temp_incorrect_index]->name;
				$output .= '<a class="choice" data-correct="false" data-name="'.$temp_incorrect_name.'" href="">'.$temp_incorrect_definition.'</a>';
			}
		}
		return $output;
	}
	function showError(){
		require('error.php');
	}
	function storeAnswer($index, $correct, $slow){
		//If correct, increment the counter for that term
		if($correct =='false'){
			--$this->vars['terms_xml']->term[(int)$index]->counter;
		}
		else{
			if($slow == "true"){
				/* $this->vars['terms_xml']->term[(int)$index]->counter -= .5; */
				return false;
			}
			else{
				++$this->vars['terms_xml']->term[(int)$index]->counter;
			}

		}
		echo($this->vars['terms_xml']->term[(int)$index]->counter);
		$this->vars['set_xml']->asXML('cache/'.$this->vars['set'].'.xml');
		return true;
	}
	function pickSet($id){
		$this->vars['set'] = $id;
		if( file_exists('cache/'.$this->vars['set'].'.xml') ){
			$set_xml = simplexml_load_file('cache/'.$this->vars['set'].'.xml');
			$this->vars['set_xml'] = $set_xml;
			return true;
		}
		else{


			$ch = curl_init('https://api.quizlet.com/2.0/sets/'.$this->vars['set'].'?client_id=kyM6yER822&whitespace=1');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$res = curl_exec($ch);
			curl_close($ch);


			if ( $json = json_decode($res) ) {
				$terms= $json->terms;
			}
			else{
				return false;
			}
			if(!$terms){
				$this->showError();
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
			$set_xml->asXML('cache/'.$this->vars['set'].'.xml');
			$this->vars['set_xml'] = $set_xml;
			
			return true;

		}
	}
	function setVars(){
		$this->vars['terms_xml'] = $this->vars['set_xml']->terms;
		$this->vars['number_of_terms'] = $this->vars['terms_xml']->term->count() - 1;
		$this->vars['correct_index'] =  rand(0,$this->vars['number_of_terms']);
		$this->vars['correct_term'] = $this->vars['terms_xml']->term[$this->vars['correct_index']];
		$this->vars['correct_term_name'] = (string)$this->vars['correct_term']->name;
		$this->vars['correct_term_definition'] = (string)$this->vars['correct_term']->definition;
	}
	function initialize(){
		if ( isset($_GET['set'])  ) {
			$temp_success = $this->pickSet($_GET['set']);
		}
		elseif( isset($_POST['set']) ){
			$temp_success = $this->pickSet($_POST['set']);
		}
		else {
			require('picker.php');
			return false;
		}
		if ($temp_success){
			$this->setVars();
			// Store an answer if we get the relevant data
			if ( isset($_POST['index']) && isset($_POST['correct']) && isset($_POST['slow']) ) {
				$this->storeAnswer($_POST['index'],$_POST['correct'],$_POST['slow']);
				return false;
			}
			// Generate a question if we get the relevant data
			elseif ( isset($_POST['questions']) && isset($_POST['choices']) ) {
				$this->generateQuestions($_POST['questions'],$_POST['choices']);
				return false;
			}
			else{
				require('tester.php');
			}
		}
	}
}
?>
