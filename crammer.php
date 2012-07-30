<?php
class Crammer
{			
	function showTest(){
		if(rand(0,1)){
		echo( '<div class="test"><h1 data-set="'. $this->vars['set'] .'"data-term="'.$this->vars['correct_index'].'">'.$this->vars['test_term_name'].'</h1><a class="button left" data-answer="1" href="">'.$this->vars['correct_definition'].'</a><a class="button right" data-answer="0" href="">'.$this->vars['incorrect_definition'].'</a></div>');
		}
		else{
			echo( '<div class="test"><h1 data-set="'. $this->vars['set'] .'"data-term="'.$this->vars['correct_index'].'">'.$this->vars['test_term_name'].'</h1><a class="button left" data-answer="0" href="">'.$this->vars['incorrect_definition'].'</a><a class="button right" data-answer="1" href="">'.$this->vars['correct_definition'].'</a></div>');
		}
	}
	function storeAnswer($term, $answer){

		if(file_exists('cache/'.$this->vars['set'].'.xml')){
			$terms_xml = simplexml_load_file('cache/'.$this->vars['set'].'.xml');
			//If correct, increment the counter for that term
			if($answer){
				echo '<span class="return-message">Correct</span>';
				 $terms_xml->term[(int)$term]->counter = ++$terms_xml->term[(int)$term]->counter;
				
			}
			else{
				echo '<span class="return-message">Incorrect</span>';
				$terms_xml->term[(int)$term]->counter = --$terms_xml->term[(int)$term]->counter;
			}
			$this->showTest();
		}
		$terms_xml->asXML('cache/'.$this->vars['set'].'.xml');
		
	}
	function initialize(){
	if ( isset($_GET['set'])  ) {
		$this->pickSet($_GET['set']);
	}
	elseif( isset($_POST['set']) ){
		$this->pickSet($_POST['set']);
	}
	else {
		return false;
	}
	$this->setVars();
	if (isset($_POST['answer']) && isset($_POST['term']) ) {
		$this->storeAnswer($_POST['term'],$_POST['answer']);
		return  true;
	}
	require('template.php');
	
	}
	function pickSet($id){
	$this->vars['set'] = $id;
		if( file_exists('cache/'.$id.'.xml') ){
			$terms_xml = simplexml_load_file('cache/'.$id.'.xml');
			$this->vars['terms_xml'] = $terms_xml;
			return true;
		}
		else{
			
		
			$ch = curl_init('https://api.quizlet.com/2.0/sets/'.$id.'?client_id=kyM6yER822&whitespace=1');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$res = curl_exec($ch);
			curl_close($ch);
		
		
			if ( $json = json_decode($res) ) {
				$terms= $json->terms;
			}
			else{
				return false;
			}
			
			$xmlstr = "<?xml version='1.0' ?><terms></terms>";
			$terms_xml = new SimpleXMLElement($xmlstr);
			foreach ($terms as $term) {
				$term_xml = $terms_xml->addChild('term');
				$term_name_xml = $term_xml->addChild('name');
				$definition_xml = $term_xml->addChild('definition');
				$counter_xml = $term_xml->addChild('counter');
				$term_xml->name = (string)$term->term;
				$term_xml->definition = (string)$term->definition;
				$term_xml->counter = 0;
			}
			$terms_xml->asXML('cache/'.$id.'.xml');
			$this->vars['terms_xml'] = $terms_xml;
			
		}
	}
	function setVars(){

		$this->vars['number_of_terms'] = $this->vars['terms_xml']->term->count() - 1;
		$this->vars['correct_index'] =  rand(0,$this->vars['number_of_terms']);
		$this->vars['incorrect_index'] =  rand(0,$this->vars['number_of_terms']);
		$this->vars['test_term'] = $this->vars['terms_xml']->term[$this->vars['correct_index']];
		$this->vars['test_term_name'] = (string)$this->vars['test_term']->name;
		$this->vars['correct_definition'] = (string)$this->vars['test_term']->definition;
		$this->vars['incorrect_term'] = $this->vars['terms_xml']->term[$this->vars['incorrect_index']];
		$this->vars['incorrect_definition'] = (string)$this->vars['incorrect_term']->definition;
		
	}
}
?>
