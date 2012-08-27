<?php
class MatchingGenerator {
	function generateQuestions($numberOfQuestions = 1, $termsXML){
		
		$numberOfQuestions= 13;
		$temp_questions_array = array();
		$temp_indexes_array = array();
		for($i=1; $i<=$numberOfQuestions; $i++){
			$temp_question_array = array();
			
			//Check that the index we get isn't already one we've picked
			$finished = false;
			while( !$finished){
				$correct_index = $this->getHardTerm($termsXML);
				if( !in_array($correct_index, $temp_indexes_array) ){
					$finished = true;
				}
			}
			$correct_term = $termsXML->term[$correct_index];
			$correct_term_name = (string)$correct_term->name;
			$correct_term_definition = (string)$correct_term->definition;
			$correct_term_counter = $correct_term->counter;

			$temp_question_array['index']= (int)$correct_index;
			$temp_question_array['counter']= (int)$correct_term_counter;
			$temp_question_array['definition']= (string)$correct_term_definition;
			$temp_question_array['name']= (string)$correct_term_name;

			array_push($temp_questions_array, $temp_question_array);
			array_push($temp_indexes_array, $correct_index);



		}
		return $temp_questions_array;

	}
	function getHardTerm($termsXML){
		$finished = false;
		$number_of_terms = $termsXML->term->count() - 1;
		while( !$finished ){
			$correct_index =  rand(0,$number_of_terms);
			$temp_counter = (int)$termsXML->term[$correct_index]->counter;
			//If the counter is negative or zero, throw it into the test
			if ( $temp_counter <= 0){
				$finished = true;
			}
			//Otherwise, pick a random number between zero and the counter and if it's zero let it in. The higher the counter the less chance of this happening.
			elseif ( rand(0, $temp_counter) == 0 ) {
				$finished = true;
			}
		}
		return $correct_index;
	}
}
