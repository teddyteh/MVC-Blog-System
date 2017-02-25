<?php

/*
* Router determines the appropriate handler controller class to forward a request to based on a URL
*/
class RouterController extends Controller {
	// Instance of the controller being called
	protected $controller;

	private function parseUrl($url)
	{
		// Parse URL parts into an associative array
		$parsedUrl = parse_url($url);
		// Remove the leading slash
		$parsedUrl["path"] = ltrim($parsedUrl["path"], "/");
		// Remove white-spaces around the address
		$parsedUrl["path"] = trim($parsedUrl["path"]);
		// Split the address by slashes
		$explodedUrl = explode("/", $parsedUrl["path"]);
		return $explodedUrl;
	}

	// Convert dashed controller name from URL into a CamelCase class name
	private function dashesToCamel($text)
	{
		$text = str_replace('-', ' ', $text);
		$text = ucwords($text);
		$text = str_replace(' ', '', $text);
		return $text;
	}

	function process($params) {
		$parsedUrl = $this->parseUrl($params);

		if (empty($parsedUrl[0]))
			$this->redirect('home');

		// The controller name is the first parameter in the url
		$controllerClass = $this->dashesToCamel(array_shift($parsedUrl)) . 'Controller';

		// Check if the controller exists
		if (file_exists('controllers/' . $controllerClass . '.php')) {	
			$this->controller = new $controllerClass;

			// Call the controller
			$this->controller->process($parsedUrl);

			// Set template variables
			$this->data['blog_title'] = $GLOBALS['config']['blog_title'];
			$this->data['blog_description'] = $GLOBALS['config']['blog_description'];

			$this->data['page_title'] = $this->controller->page['title'];
			
			$this->view = 'layout';
		} else {
			$this->redirect('error');
		}
	}
}