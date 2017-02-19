<?php

class BlogManager {
	// Returns an article from the database based on a URL
    public function getPostById($id)
    {
    	return Db::queryOne('
            SELECT *
            FROM posts
            WHERE id = ?
        ', array($id));
    }

    public function getPosts($number)
    {
        return Db::queryAll('
            SELECT *
            FROM posts
            ORDER BY id DESC
        ');
    }

    public function savePost($id, $post)
	{
        if (!$id)
            Db::insert('posts', $post);
        else
            Db::update('posts', $post, 'WHERE id = ?', array($id));
	}

	public function removeArticle($id)
	{
        Db::query('
            DELETE FROM posts
            WHERE id = ?
        ', array($id));
	}
}