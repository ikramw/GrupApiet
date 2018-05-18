<?php

namespace App\Controllers;

class UserController
{
    private $db;
    
    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAll()
    {
        $getAllUsers = $this->db->prepare("SELECT * FROM users");
        $getAllUsers->execute();
        $allUsers = $getAllUsers->fetchAll();
        return $allUsers;
    }

    public function getOne($id)
    {
        $getOneUser = $this->db->prepare("SELECT * FROM users WHERE userID = :id");
        $getOneUser->execute([
          ":id" => $id
        ]);
        // Fetch -> single resource
        $oneUser = $getOneUser->fetch();
        return $oneUser;
    }
    public function add($user)
    {
        /**
         * Default 'completed' is false so we only need to insert the 'content'
         */
        $addOne = $this->db->prepare(
            'INSERT INTO users (username, password, createdAt) 
            VALUES (:username, :password, :createdAt)'
        );

        /**
         * Insert the value from the parameter into the database
         */
        $addOne->execute([':username'  => $user['username'],
        ':password'  => $user['password'],
        ':createdAt'  => date("Y-m-d H:i:s")
        ]);

        /**
         * A INSERT INTO does not return the created object. If we want to return it to the user
         * that has posted the todo we must build it ourself or fetch it after we have inserted it
         * We can always get the last inserted row in a database by calling 'lastInsertId()'-function
         */
        return [
          'userID'      => (int)$this->db->lastInsertId(),
          'username'    => $user['username'],
          'createdAt'   => $user['createdAt']
        ];
    }
    
    
}
