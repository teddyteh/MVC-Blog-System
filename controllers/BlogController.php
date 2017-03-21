<?php

/*
* Handles blog post requests
*/
class BlogController extends Controller {
	function process($params) {
		// The BlogManager model class manages blog posts
        $blogManager = new BlogManager();

		$this->page['title'] = 'Blog';

        // Check if a post id is given
        if (!empty($params[0])) {
            // Get the post
            $post = $blogManager->getPostById($params[0]);

            // A post by the given id doesn't exist
            if (!$post)
                $this->redirect('error');
            
            $this->data['post'] = $post;

            $this->view = 'post';            
        } else {
            // No id is given, get the latest 5 posts
            $posts = $blogManager->getPosts(5);

            $this->data['posts'] = $posts;
            
            $this->view = 'posts';
        }
	}
}