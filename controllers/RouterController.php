<?php

class RouterController extends Controller {
	protected $controller;

	private function parseUrl($url)
	{
		// Splits the address by slashes
		$explodedUrl = explode("/", ltrim($url,"/"));

		// print_r($explodedUrl);
		return $explodedUrl;
	}

	function process($params) {
		$parsedUrl = $this->parseUrl($params);

		if (empty($parsedUrl[0]))
			$this->redirect('error');

		// The controller name is the 1st URL parameter
		$controllerClass = $parsedUrl[0] . 'Controller';

		if (file_exists('controllers/' . $controllerClass . '.php')) {
			$this->controller = new $controllerClass;

			// action
			$this->controller->process($parsedUrl);

			$this->data['blog_title'] = "A cute blog";
			$this->data['page_title'] = $this->controller->page['title'];
			
			// Sets the main template
			$this->view = 'layout';
		} else {
			$this->redirect('error');
		}
	}
}