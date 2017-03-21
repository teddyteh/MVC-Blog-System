<?php

$config = require('config.php');

session_start();

spl_autoload_register(function ($class_name) {
	// Ends with a string "Controller"?
    if (preg_match('/Controller$/', $class_name))
        require("controllers/" . $class_name . ".php");
    else
        require("models/" . $class_name .  ".php");
});

// Connects to the database
Db::connect($config['host'], $config['user'], $config['pass'], $config['table']);

$router = new RouterController();
$router->process($_SERVER['REQUEST_URI']);
$router->renderView();