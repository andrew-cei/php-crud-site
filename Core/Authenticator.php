<?php

namespace Core;
use Core\App;
use Core\Session;

class Authenticator{
    public function attempt($email, $password){
        $user = App::resolve(Database::class)->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        if ($user){
            // We have a user, nut we don't know if the password provided matches what we have in the database.
            if (password_verify($password, $user['password'])){
                $this->login([
                    'email' => $email
                ]);
        
                return true;
            }
        }
        return false;
    }

    
    public function login($user){
        $_SESSION['user'] = [
            'email' => $user['email']
        ];

        session_regenerate_id(true);
    }

    public function logout(){
        // Log the user out
        Session::destroy();
    }
}