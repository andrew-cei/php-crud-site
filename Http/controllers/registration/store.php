<?php
use Core\Authenticator;
use Core\App;
use Core\Database;
use Core\Validator;

$db = APP::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

// Validate the form inputs
$errors = [];

if (!Validator::email($email)){
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password,7,255)){
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

if(! empty($errors)){
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}

// Check if the account already exist
$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($user) {
    // If yes, redirect to a login page
    header('location: /');
    exit();
} else {
    // If not, save one to the database
    $db->query('INSERT INTO users(email, password) VALUES(:email, :password)',[
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    // Mark that the user has logged in
    (new Authenticator)->login([
        'email' => $email
    ]);

    header('location: /');
    exit();
}