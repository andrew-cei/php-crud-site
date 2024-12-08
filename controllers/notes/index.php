<?php
use Core\Database;

// Connect to our MySQL database.
$config = require base_path('config.php');

$db = new Database($config['database']);

$notes = $db->query('SELECT * FROM notes WHERE user_id = 4')->get();

view("notes/index.view.php", [
    'heading' => 'My notes',
    'notes' => $notes
]);