<?php

class BlogController extends Controller {
	function process($params) {
		$blogManager = new BlogManager();

		// HTML head
        $this->page = array(
            'title' => "Blog",
        );

        if (!empty($params[1])) {
            $post = $blogManager->getPostById($params[1]);

            if (!$post)
                $this->redirect('error');
            
            // Sets the template variables
            $this->data['post'] = $post;

            // Sets the template
            $this->view = 'post';            
        } else {
            $posts = $blogManager->getPosts(5);

            $this->data['posts'] = $posts;
            $this->view = 'posts';
        }
	}
}