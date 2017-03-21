<?php

/*
* Handles blog listing by tags
*/
class TagController extends Controller
{
    public function process($params)
    {
        // The BlogManager model class manages blog posts
        $blogManager = new BlogManager();

        $this->page['title'] = 'Blog';

        // Check if a post id is given
        if (!empty($params[0])) {
            // Get the post
            $posts = $blogManager->getPostByTag($params[0]);

            // A post by the given id doesn't exist
            if (!$posts)
                $this->redirect('error');
            
            $this->data['posts'] = $posts;
            $this->data['tag'] = $params[0];

            $this->view = 'tag';
        }
    }
}