<?php
use Core\App;
use Core\Database;
use Core\Validator;

$db = APP::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if (!Validator::email($email)){
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password,7,255)){
    $errors['password'] = 'Please provide a valid password.';
}

if (! empty($errors)) {
    return view('sessions/create.view.php', [
        'errors' => $errors
    ]);
}

// Log in the user if the credentials match
$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($user){
    // We have a user, nut we don't know if the password provided matches what we have in the database.
    if (password_verify($password, $user['password'])){
        login([
            'email' => $email
        ]);

        header('location: /');
        exit();
    }
}

return view('session/create.view.php', [
    'errors' => [
        'email' => 'No matching account found for that email address and password.'
    ]
]);