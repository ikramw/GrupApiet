<?php

namespace App\Controllers;

class CommentController
{
    private $db;
    
    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAll()
    {
        $getAllComments = $this->db->prepare("SELECT * FROM comments");
        $getAllComments->execute();
        return $getAllUsers->fetchAll();         
    }

    public function getOne($id)
    {
        $getOneComment = $this->db->prepare("SELECT * FROM comments WHERE commentID = :id");
        $getOneComment->execute([
          ":id" => $id
        ]);
        // Fetch -> single resource
        return $getOneComment->fetch();
    }
    public function add($comment)
    {
        /**
         * Default 'completed' is false so we only need to insert the 'content'
         */
        $addOne = $this->db->prepare(
            'INSERT INTO comments (entryID, content, createdBy, createdAt) 
            VALUES (:entryID, :content, :createdBy, :createdAt)'
        );

        /**
         * Insert the value from the parameter into the database
         */
        $addOne->execute(
       [':entryID'  => $user['entryID'],
        ':content'  => $user['content'],
        ':createdBy'  => $user['createdBy'],
        ':createdAt'  => $user['createdAt']]);

        /**
         * A INSERT INTO does not return the created object. If we want to return it to the user
         * that has posted the todo we must build it ourself or fetch it after we have inserted it
         * We can always get the last inserted row in a database by calling 'lastInsertId()'-function
         */
        return [
        'commentID'      => (int)$this->db->lastInsertId(),
        'entryID'  => $user['entryID'],
        'content'  => $user['content'],
        'createdBy'  => $user['createdBy'],
        'createdAt'  => $user['createdAt']
        ];
    }
    
    
}
