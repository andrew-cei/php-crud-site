<?php

require 'functions.php';
require 'Database.php';
//require 'router.php';

// Connect to our MySQL database.

$config = require('config.php');

$db = new Database($config['database']);

$id = $_GET['id'];

$query = "SELECT * FROM posts WHERE id = :id";

$posts = $db->query($query, ['id' => $id])->fetch();



dd($posts);