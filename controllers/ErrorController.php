<?php

class ErrorController extends Controller
{
    public function process($params)
    {
    	// HTTP header
        header("HTTP/1.0 404 Not Found");
		// HTML header
        $this->page['title'] = 'Error 404';
        // Sets the template
        $this->view = 'error';
    }
}