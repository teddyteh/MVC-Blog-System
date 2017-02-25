<?php

/*
* Handles the post editor
*/
class PostsController extends Controller
{
    public function process($params)
    {
        // Only authorized users can access the editor
        $this->authUser();

        // The BlogManager model class manages blog posts
        $blogManager = new BlogManager();

        // Create an empty post
        $post = array(
            'title' => '',
            'content' => '',
        );

        // Add a post
        if (!empty($params[0]) && (strcmp($params[0],"add") == 0))
        {
        	$this->page['title'] = 'Add a post';

            // Add a new post
            if ($_POST)
            {
                $keys = array('title', 'content');
                $post = array_intersect_key($_POST, array_flip($keys));

                $user = $this->getUser();
                $post['posted_by'] = $user['user_id'];
                
                $blogManager->savePost(null, $post);

                $this->redirect('blog');
            }

            $this->data['page_title'] = $this->page['title'];
            $this->data['post'] = $post;

            $this->view = 'editor';
        }
        // Edit a post
        else if (!empty($params[0]) && !empty($params[1]) && (strcmp($params[0],"edit") == 0))
        {
        	$this->page['title'] = 'Edit a post';
        	
            // Save changes of an edited post
            if ($_POST)
            {
                $keys = array('title', 'content');
                $post = array_intersect_key($_POST, array_flip($keys));
                
                $blogManager->savePost($_POST['post_id'], $post);

                $this->redirect('blog/' . $_POST['post_id']);
            }

            // Get the post by the given id
            $loadedPost = $blogManager->getPostById($params[1]);

            if ($loadedPost)
                $post = $loadedPost;
            else
                echo('The article was not found.');

            $this->data['page_title'] = $this->page['title'];
            $this->data['post'] = $post;

            $this->view = 'editor';
        }
        // Remove a post
        else if (!empty($params[0]) && !empty($params[1]) && (strcmp($params[0],"remove") == 0))
        {
            // Get the post by the given id
            $loadedPost = $blogManager->getPostById($params[1]);

            if ($loadedPost)
            {
                $blogManager->removePost($loadedPost['post_id']);
                $this->redirect('blog');
            }
            else
                echo('The article was not found.');
        }   
    }
}