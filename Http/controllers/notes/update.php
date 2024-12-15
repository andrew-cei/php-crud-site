<?php
use Core\App;
use Core\Database;
use Core\Validator;

// Connect to our MySQL database.
$db = App::resolve(Database::class);
$currentUserId = 4;

// Find the note
$note = $db->query('SELECT * FROM notes WHERE id = :id', ['id' => $_POST['id']])->findOrFail();

// Authorize
authorize($note['user_id'] === $currentUserId);

// Validate the form
$errors = [];

if (! Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}

//Update records
if (count($errors)) {
    return view('notes/edit.view.php', [
        'heading' => 'Edit Note',
        'errors' => $errors,
        'note' => $note
    ]);
}

$db->query('UPDATE notes SET body = :body WHERE id = :id', [
    'id' => $_POST['id'],
    'body' => $_POST['body']
]);

// Redirect
header('location: /notes');
die();