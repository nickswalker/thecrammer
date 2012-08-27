<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	 public function __construct()
{
    //Assets
    Asset::add('style', 'css/style.css');
    
    parent::__construct();
}
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}