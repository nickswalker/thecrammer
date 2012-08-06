<?php
class Crammer
{
	function generateQuestions($numberOfQuestions = 1, $numberOfChoices = 2){
		echo( '<div class="test"><h1 data-set="'. $this->vars['set'] .'"data-term="'.$this->vars['correct_index'].'">'.$this->vars['test_term_name'].'</h1>'. $this->generateChoices($numberOfChoices) .'</div>');

	}
	function generateChoices($numberOfChoices = 2){

		$correctSpot = rand(1,(int)$numberOfChoices);
		for ($i = 1; $i <= $numberOfChoices; $i++) {
			if($i == $correctSpot){
				$output .= '<a class="button" data-answer="1" href="">'. $this->vars['correct_definition'] .'</a>';
			}
			else{
				$temp_incorrect_index = rand(0,$this->vars['number_of_terms']);
				if ($temp_incorrect_index == $this->vars['correct_index']){
					$temp_incorrect_index = rand(0,$this->vars['number_of_terms']);
				}
				$temp_incorrect_definition = (string)$this->vars['terms_xml']->term[$temp_incorrect_index]->definition;
				$output .= '<a class="button" data-answer="0" href="">'.$temp_incorrect_definition.'</a>';
			}
		}
		return $output;
	}
	function showError(){
		require('error.php');
	}
	function storeAnswer($term, $answer, $slow){
		//If correct, increment the counter for that term
		if(!$answer){
			$this->vars['terms_xml']->term[(int)$term]->counter = --$this->vars['terms_xml']->term[(int)$term]->counter;
		}
		else{
			if($slow){
				/* $terms_xml->term[(int)$term]->counter = $terms_xml->term[(int)$term]->counter - .5; */
				return false;
			}
			else{
				$this->vars['terms_xml']->term[(int)$term]->counter = ++$this->vars['terms_xml']->term[(int)$term]->counter;
			}

		}
		$terms_xml->asXML('cache/'.$this->vars['set'].'.xml');
		return true;
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
			if ( isset($_POST['answer']) && isset($_POST['term']) && isset($_POST['slow']) ) {
				$this->storeAnswer($_POST['term'],$_POST['answer'],$_POST['slow']);
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
	function pickSet($id){
		$this->vars['set'] = $id;
		if( file_exists('cache/'.$this->vars['set'].'.xml') ){
			$terms_xml = simplexml_load_file('cache/'.$this->vars['set'].'.xml');
			$this->vars['terms_xml'] = $terms_xml;
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
			$xmlstr = "<?xml version='1.0' ?><terms></terms>";
			$terms_xml = new SimpleXMLElement($xmlstr);
			foreach ($terms as $term) {
				$term_xml = $terms_xml->addChild('term');
				$term_name_xml = $term_xml->addChild('name');
				$definition_xml = $term_xml->addChild('definition');
				$counter_xml = $term_xml->addChild('counter');
				$term_xml->name = htmlspecialchars((string)$term->term);
				$term_xml->definition = htmlspecialchars((string)$term->definition);
				/* $term_xml->counter = 0; */
			}
			$terms_xml->asXML('cache/'.$this->vars['set'].'.xml');
			$this->vars['terms_xml'] = $terms_xml;
			return true;

		}
	}
	function setVars(){

		$this->vars['number_of_terms'] = $this->vars['terms_xml']->term->count() - 1;
		$this->vars['correct_index'] =  rand(0,$this->vars['number_of_terms']);
		$this->vars['test_term'] = $this->vars['terms_xml']->term[$this->vars['correct_index']];
		$this->vars['test_term_name'] = (string)$this->vars['test_term']->name;
		$this->vars['correct_definition'] = (string)$this->vars['test_term']->definition;


	}
}
?>
