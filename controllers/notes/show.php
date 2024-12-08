<?php
use Core\App;
use Core\Database;

// Connect to our MySQL database.
$db = App::resolve(Database::class);
$currentUserId = 4;

$note = $db->query('SELECT * FROM notes WHERE id = :id', ['id' => $_GET['id']])->findOrFail();

authorize($note['user_id'] === $currentUserId);

view("notes/show.view.php", [
    'heading' => 'Note',
    'note' => $note
]);
