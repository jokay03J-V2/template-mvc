<?php

namespace Project\Controllers;

use Project\Models\UserManager;

class UserController extends BaseController
{
    private $manager;

    public function __construct()
    {
        $this->manager = new UserManager();
    }

    public function showLogin()
    {
        // render login view
        require VIEWS . 'Auth/login.php';
    }

    public function showRegister()
    {
        // render register view
        require VIEWS . 'Auth/register.php';
    }

    public function logout()
    {
        // remove all session datas
        session_start();
        session_destroy();
        header('Location: /login/');
    }

    public function register()
    {
        // validate request
        $this->validator->validate([
            "username" => ["required", "min:3", "alphaNum"],
            "password" => ["required", "min:6", "alphaNum", "confirm"],
            "passwordConfirm" => ["required", "min:6", "alphaNum"]
        ]);
        // store all previous form data
        $_SESSION['old'] = $_POST;
        // check if validator has errors
        if (!$this->validator->errors()) {
            // get user
            $res = $this->manager->find($_POST["username"]);
            // if user doesn't exist, let's create it
            if (empty($res)) {
                // generate password hash
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                // store user and return generated id
                $generatedId = $this->manager->store(htmlspecialchars($_POST["username"]), $password);
                // set user in the session
                $_SESSION["user"] = [
                    "id" => $generatedId,
                    "username" => htmlspecialchars($_POST["username"])
                ];
                header("Location: /");
            } else {
                // display already user created error
                $_SESSION["error"]['username'] = "Le username choisi est déjà utilisé !";
                header("Location: /register");
            }
        } else {
            // render register view
            header("Location: /register");
        }
    }

    public function login()
    {
        // validate request
        $this->validator->validate([
            "username" => ["required", "min:3", "max:9", "alphaNum"],
            "password" => ["required", "min:6", "alphaNum"]
        ]);
        // store all previous form data
        $_SESSION['old'] = $_POST;
        // check if validator has errors
        if (!$this->validator->errors()) {
            // get user
            $res = $this->manager->find($_POST["username"]);
            // if user has been found, check password hash and provided password
            if ($res && password_verify($_POST['password'], $res->getPassword())) {
                // set user in the session
                $_SESSION["user"] = [
                    "id" => $res->getId(),
                    "username" => $res->getUsername()
                ];
                header("Location: /");
            } else {
                // handle wrong identifier
                $_SESSION["error"]['message'] = "Une erreur sur les identifiants";
                header("Location: /login");
            }
        } else {
            header("Location: /login");
        }
    }
}
