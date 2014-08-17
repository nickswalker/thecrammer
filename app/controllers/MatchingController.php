<?php

class MatchingController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/

	public function action_index($set)
	{
		$model = new Base;
		$setVars = $model->setVars($set);
		$data['setID'] = $setVars['set'];
		$data['setTitle'] = $setVars['set_title'];
		$data['setDescription'] = $setVars['set_description'];
		
		
		return View::make('matching', $data);
	}
	public function action_getQuestions($set){
	
		$model = new Base;
		$setVars = $model->setVars($set);
		
		$generator = new MatchingGenerator;
		$temp_matching = $generator->generateQuestions(26, $setVars['set_xml']->terms  );
		$data['questions'] = $temp_matching;
		return View::make('matchingquestions', $data);

	}
	public function action_postAnswers($set){

		$model = new Base;
		$setVars = $model->setVars($set);
		print_r(Input::get('answers'));
		$model->storeAnswers(Input::get('answers'));
	}
	
	
}
