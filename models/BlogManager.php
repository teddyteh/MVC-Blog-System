<?php

/*
* Manages blog posts
*/
class BlogManager {
	// Return a post given an id
    public function getPostById($id)
    {
    	return Db::queryOne('
            SELECT posts.*, users.name, GROUP_CONCAT(tags.tag_name ORDER BY tags.tag_name) AS tags
            FROM posts
            LEFT JOIN users ON users.user_id = posts.posted_by
            LEFT JOIN posts_tags ON posts_tags.post_id = posts.post_id
            LEFT JOIN tags ON tags.tag_id = posts_tags.tag_id
            WHERE posts.post_id = ?
            GROUP BY posts.post_id
        ', array($id));
    }

    // Return all posts associated with a tag
    public function getPostByTag($tag)
    {
        return Db::queryAll('
            SELECT posts.*, users.name
            FROM posts
            LEFT JOIN users ON users.user_id = posts.posted_by
            LEFT JOIN posts_tags ON posts_tags.post_id = posts.post_id
            LEFT JOIN tags ON tags.tag_id = posts_tags.tag_id
            WHERE tags.tag_name = ?
            GROUP BY posts.post_id DESC LIMIT 0, 5
        ', array($tag));
    }

    // Return a tag
    public function getTagByName($tag)
    {
        return Db::queryOne('
            SELECT *
            FROM tags
            WHERE tag_name = ?
        ', array($tag));
    }

    // Return the specified number of posts
    public function getPosts($number)
    {
        return Db::queryAll('
            SELECT posts.*, users.name, GROUP_CONCAT(tags.tag_name ORDER BY tags.tag_name) AS tags
            FROM posts
            LEFT JOIN users ON users.user_id = posts.posted_by
            LEFT JOIN posts_tags ON posts_tags.post_id = posts.post_id
            LEFT JOIN tags ON tags.tag_id = posts_tags.tag_id
            GROUP BY posts.post_id DESC LIMIT 0, 5
        ', array($number));
    }

    // Return all tags
    public function getTags()
    {
        return Db::queryAll('
            SELECT *
            FROM tags
        ');
    }

    // Save changes to a post
    public function savePost($id, $post)
	{
        if (!$id)
            Db::insert('posts', $post);
        else
            Db::update('posts', $post, 'WHERE post_id = ?', array($id));
	}

    // Add a tag
    public function addTag($tag)
    {
        $tagArray = array('tag_name' => $tag);
        Db::insert('tags', $tagArray);
    }

    // Save tags for given post
    public function saveTags($id, $tags, $allTags)
    {
        // Check if any tag was selected
        if ($tags == null || !is_array($tags))
            $tags = array();
        
        // Convert all tags of the post to an array
        $allTagsArray = array();
        foreach ($allTags as $tag)
        {
            array_push($allTagsArray, $tag["tag_id"]);
        }
        
        // Iterate through every tag
        foreach ($allTagsArray as $allTag)
        {
            // Check if the current tag is selected by the user
            if (in_array($allTag, $tags))
            {
                // Add the relationship to the posts_tags table if the tag is selected. The query will be executed whether or not the query already exists.
                Db::queryTest('
                    INSERT INTO posts_tags
                    VALUES (?, ?, ?)
                ', array(
                    "id" => null,
                    "post_id" => $id,
                    "tag_id" => $allTag
                ));
            }
            else
            {
                // Otherwise remove the relationship from the table
               Db::queryTest('
                    DELETE from posts_tags
                    WHERE post_id = ? AND tag_id = ?
                ', array(
                    "post_id" => $id,
                    "tag_id" => $allTag
                ));
            }
        }
    }

    // Remove a post
    public function removePost($id)
	{
        Db::query('
            DELETE FROM posts_tags
            WHERE post_id = ?
        ', array($id));

        Db::query('
            DELETE FROM posts
            WHERE post_id = ?
        ', array($id));
	}

    // Get the id of the last added post
    public function getLastPostId()
    {
        return Db::getLastId();
    }

    // Get the id of the last added tag
    public function getLastTagId()
    {
        return Db::getLastId();
    }
}