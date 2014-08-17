<?php

class MultipleChoiceController extends BaseController {

	public function index($setID, $numberOfChoices = 4){
		$model = new \Libraries\Base;
		$setIDVars = $model->setVars($setID);
		$data['setID'] = $setIDVars['set'];
		$data['setTitle'] = $setIDVars['set_title'];
		$data['setDescription'] = $setIDVars['set_description'];
		$data['choices'] = $numberOfChoices;
		return View::make('multichoice', $data);
	}
	public function getQuestions($setID){
	
		$model = new \Libraries\Base;
		$setIDVars = $model->setVars($setID);
			
		$generator = new \Libraries\QuestionGenerator;
		$data['questions'] = $generator->generateQuestions( (int)Input::get('questions'), (int)Input::get('choices'), $setIDVars['set_xml']->terms );
		/*
echo '<pre>';
		print_r($data['questions']);
		echo '</pre>';
*/
		return View::make('multichoicequestions', $data);

	}
	public function postAnswers($setID){

		$model = new \Libraries\Base;
		$setIDVars = $model->setVars($setID);
		$model->storeAnswers(Input::get('answers'));
	}
	
	
}
