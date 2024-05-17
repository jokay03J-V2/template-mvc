<?php
namespace Project\Models;

use Project\Models\User;

class UserManager extends BaseManager
{

    /**
     * Find user by its username.
     * Return an User instance or false.
     */
    public function find($username): User|false
    {
        // prepare query
        $stmt = $this->bdd->prepare("SELECT * FROM user WHERE username = ?");
        // execute query and fetch as User class
        $stmt->execute(
            array(
                $username
            )
        );
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);

        return $stmt->fetch();
    }

    /**
     * Store an User.
     * Return generated user id.
     */
    public function store(string $username, string $password): string
    {
        // prepare query
        $stmt = $this->bdd->prepare("INSERT INTO user(id, username, password) VALUES (:id, :name, :password)");
        // generate uniqu id
        $id = uniqid();
        // execute query
        $stmt->execute([
            "id" => $id,
            "name" => htmlspecialchars($username),
            "password" => $password
        ]);

        return $id;
    }
}
