<?php

/*
* Manages blog posts
*/
class BlogManager {
	// Return a post given an id
    public function getPostById($id)
    {
    	return Db::queryOne('
            SELECT posts.*, users.name
            FROM posts
            LEFT JOIN users
            ON posts.posted_by = users.user_id
            WHERE posts.post_id = ?
        ', array($id));
    }

    // Return the specified number of posts
    public function getPosts($number)
    {
        return Db::queryAll('
            SELECT posts.*, users.name
            FROM posts
            LEFT JOIN users
            ON posts.posted_by = users.user_id
            ORDER BY post_id DESC
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

    // Remove a post
    public function removePost($id)
	{
        Db::query('
            DELETE FROM posts
            WHERE post_id = ?
        ', array($id));
	}

    // Get the id of the last inserted post
    public function getLastPostId()
    {
        return Db::getLastId();
    }
}