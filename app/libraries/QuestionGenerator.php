<?php
namespace Libraries;
class QuestionGenerator {
	function generateQuestions($numberOfQuestions = 1, $numberOfChoices = 4, $termsXML){
		$temp_questions_array = array();
		if($numberOfChoices == '' || !is_numeric($numberOfChoices)){
			$numberOfChoices = 4;
		}
		for($i=1; $i<=$numberOfQuestions; $i++){
			$temp_question_array = array();



			$temp_choices_array = $this->generateChoices($numberOfChoices, $termsXML);

			array_push($temp_questions_array, $temp_choices_array);



		}
		return $temp_questions_array;

	}

	function generateChoices($numberOfChoices = 4,$termsXML){
		$temp_choices_array = array();
		$number_of_terms = $termsXML->term->count() - 1;


		for ($x = 1; $x <= $numberOfChoices; $x++) {
			$temp_choice_array = array();

			//Come up with the term we want to test based on the counter
			$finished = false;
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


			//If the current iteration happens to be the spot we determined we want the correct answer to go, put the correct stuff
			if($x == 1){

				$correct_term = $termsXML->term[$correct_index];
				$correct_term_name = (string)$correct_term->name;
				$correct_term_definition = (string)$correct_term->definition;
				$correct_term_counter = $correct_term->counter;

				$temp_choice_array['isCorrect']= 'true';
				$temp_choice_array['index']= (int)$correct_index;
				$temp_choice_array['counter']= (int)$correct_term_counter;
				$temp_choice_array['definition']= (string)$correct_term_definition;
				$temp_choice_array['name']= (string)$correct_term_name;
				array_push($temp_choices_array, $temp_choice_array);


			}
			//Otherwise...
			else{
				//Pick some random data and check that it's not the same as the correct data
				$finished = false;
				while( !$finished ){
					$incorrect_index = rand(0,$number_of_terms);

					//If the counter is negative or zero, throw it into the test
					if ( $incorrect_index != $correct_index ){
						$finished = true;
					}
				}

				$incorrect_term = $termsXML->term[$incorrect_index];
				$temp_choice_array['isCorrect']= 'false';
				$temp_choice_array['index']= $incorrect_index;
				$temp_choice_array['counter']= (int)$incorrect_term->counter;
				$temp_choice_array['definition']= (string)$incorrect_term->definition;
				$temp_choice_array['name']= (string)$incorrect_term->name;


				array_push($temp_choices_array, $temp_choice_array);


			}

		}
		return ($temp_choices_array);
	}

}
/*
$answers .= '<a class="choice" data-correct="false" data-name="'.$temp_incorrect_name.'" href="">'.$temp_incorrect_definition.'</a>';
			$answers .= '<div class="test"><h1 data-index="'.$correct_index.'" data-difficulty="'.$termsXML->term[$correct_index]->counter .'">'.$correct_term_name.'</h1>'. $answers .'</div>';
		$answers .= '<a class="choice" data-correct="true" href="" data-definition="'.  .'">'.  .'</a>';
*/