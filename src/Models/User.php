<?php
namespace Project\Models;

/** Class User **/
class User {

    private $username;
    private $password;
    private $id;

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getId() {
        return $this->id;
    }

    public function setUsername(String $username) {
        $this->username = $username;
    }

    public function setPassword(String $password) {
        $this->password = $password;
    }

    public function setId(Int $id) {
        $this->id = $id;
    }
}
