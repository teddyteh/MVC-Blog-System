<?php

/*
* Error page
*/
class ErrorController extends Controller
{
    public function process($params)
    {
    	header("HTTP/1.0 404 Not Found");
		
		$this->page['title'] = 'Error 404';
        
        $this->view = 'error';
    }
}