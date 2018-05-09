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
        $getOneUser = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $getOneUser->execute([
          ":id" => $id
        ]);
        // Fetch -> single resource
        $oneUser = $getOneUser->fetch();
        return $oneUser;
    }
   /* public function add()
    {
        $addOneUser = $this->db->prepare("INSERT INTO users (username, password, createdAt)
        VALUES (value1, value2, value3, ...);");
        $addOneUser->execute();
        // Fetch -> single resource
       // $oneUser = $getOneUser->fetch();
       // return $oneUser;
    }*/
}
