<?php 

require_once __DIR__ . '/api/UserController.php';

class AuthController {

    
    public static function register_user() {
        global $auth;
        try {
            $userId = $auth->register($_POST['email'], $_POST['password']);
            $msg = 'We have signed up a new user with the ID ' . $userId;
            // Flight::redirect('/');
        }                   
        catch (\Delight\Auth\InvalidEmailException $e) {
            $msg = 'Invalid email address';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $msg = 'Invalid password';
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $msg = 'User already exists'.$e;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $msg = 'Too many requests';
        }
        return $msg;
    }

    public static function login_user() {
        global $auth;
        try {
            $auth->login($_POST['email'], $_POST['password']);
            $msg = 'success';
            Flight::redirect('/');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $msg = 'Wrong email address';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $msg = 'Wrong password';
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $msg = 'Email not verified';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $msg = 'Too many requests';
        }
        return $msg;
    }

    public static function logout_user() {
        global $auth;
        try {
            $auth->logOutEverywhere();
            Flight::redirect("/");
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in');
        }       
    }

    public static function register() {
        if(isset($_POST['submitButton'])){
            $msg = self::register_user();
            render_view("auth/register", ['msg' => $msg]);
        } else {
            render_view("auth/register", ['msg' => '']);
        }
    }

    public static function login() {
        if(isset($_POST['submitButton'])){
            $msg = self::login_user();
            render_view("auth/login", ['msg' => $msg]);
        } else {
            render_view("auth/login", ['msg' => '']);
        }
    }

    public static function logout() {
        self::logout_user();
    }

}
