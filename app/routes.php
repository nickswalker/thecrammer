<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('{setID}', 'StatisticsController@index')
	->where('setid','[0-9]+');
Route::post('postanswers/(:any)', 'AnswersController@index');

Route::post('multichoice/({setID}/postanswers', 'MultipleChoiceController@postAnswers')
	->where('setid','[0-9]+');
Route::match(array('GET', 'POST'), 'multichoice/{setID}/getquestions', 'MultipleChoiceController@getQuestions')
	->where('setID','[0-9]+');
Route::get('multichoice/{setID}/{numberOfChoices?}', 'MultipleChoiceController@index')
	->where( array('id'=>'[0-9]+', 'numberOfChoices' =>'[0-9]+') );

Route::get('matching/{setID}/{numberOfChoices?}', 'MatchingController@index');
Route::match(array('GET', 'POST'), 'matching/{setID}/getquestions', 'MatchingController@getQuestions');

Route::get('/', 'PickerController@index');


