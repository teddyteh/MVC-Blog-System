<?php

class EditorController extends Controller
{
    public function process($params)
    {
        // Creates a model instance
        $blogManager = new BlogManager();

        // Prepares an empty article
        $post = array(
            'title' => '',
            'content' => '',
        );

        // Was the form submitted?
        if ($_POST)
        {
            // Retrieves the article from POST
            $keys = array('title', 'content');
            $post = array_intersect_key($_POST, array_flip($keys));
            
            // Stores the article into the database
            $blogManager->savePost($_POST['post_id'], $post);

            $this->redirect('blog/' . $_POST['post_id']);
        }
        else if (empty($params[1]))
        {
        	// HTML head
        	$this->page['title'] = 'Add a post';
        }
        // Was the article URL entered with the intent to edit said article?
        else if (!empty($params[1]))
        {
        	// HTML head
        	$this->page['title'] = 'Edit a post';
        	
            $loadedPost = $blogManager->getPostById($params[1]);
            if ($loadedPost)
                $post = $loadedPost;
            else
                echo('The article was not found.');
        }

        $this->data['page_title'] = $this->page['title'];
        $this->data['post'] = $post;
        $this->view = 'editor';
    }
}