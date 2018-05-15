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
        $limit=3;
        $getAllComments = $this->db->prepare("SELECT * FROM comments ORDER BY createdAt DESC LIMIT :limit");
        $getAllComments->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $getAllComments->execute();
        return $getAllComments->fetchAll();  
               
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
    public function getByEntry($entryId)
    {
        $getCommentByEntry = $this->db->prepare("SELECT * FROM comments WHERE entryID = :id");
        $getCommentByEntry->execute([
          ":id" => $entryId
        ]);
        return $getCommentByEntry->fetchAll();
    }
    public function add($comment)
    {        
        $addOne = $this->db->prepare(
            'INSERT INTO comments (entryID, content, createdBy, createdAt) 
            VALUES (:entryID, :content, :createdBy, :createdAt)'
        );

        /**
         * Insert the value from the parameter into the database
         */
        $addOne->execute(
       [':entryID'  => $comment['entryID'],
        ':content'  => $comment['content'],
        ':createdBy'  => $comment['createdBy'],
        ':createdAt'  => $comment['createdAt']]
    );
        
        return [
        'commentID'      => (int)$this->db->lastInsertId(),
        'entryID'  => $comment['entryID'],
        'content'  => $comment['content'],
        'createdBy'  => $comment['createdBy'],
        'createdAt'  => $comment['createdAt']
        ];
    }
    public function delete($id){
        $deleteOneComment = $this->db->prepare("DELETE FROM comments WHERE commentID = :id");
        $deleteOneComment->execute([
          ":id" => $id
        ]);
    }
    
}
