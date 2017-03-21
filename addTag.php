<?php

if ($tag = $_GET['tag']) {
	require("models/Db.php");
	require("models/BlogManager.php");

	$config = require('config.php');
	Db::connect($config['host'], $config['user'], $config['pass'], $config['table']);

	$blogManager = new BlogManager();

	if ($blogManager->getTagByName($tag) == 0) {
		$blogManager->addTag(strtolower($tag));
		
		$id = $blogManager->getLastTagId();
		echo '<input id="tag-' . $id . '" type="checkbox" name="tags[]" class="vis-hidden" value="' . $id . '" checked />';
		echo '<label for="tag-' . $id . '">' . $tag . '</label>';
	} else {
		echo "Tag already exists";
		header('HTTP/1.1 400 Bad Request');
	}
}