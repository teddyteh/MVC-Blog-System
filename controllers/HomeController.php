<?php

/*
* Homepage
*/
class HomeController extends Controller
{
    public function process($params)
    {
    	// The BlogManager model class manages blog posts
        $blogManager = new BlogManager();

        $this->page['title'] = 'Home';

        $post = $blogManager->getPostById(1);

        $this->data['post'] = $post;

        $this->view = 'post';
    }
}