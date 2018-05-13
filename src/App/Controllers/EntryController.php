<?php

namespace App\Controllers;

class EntryController
{
    private $db;
    
    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAll(){
        $limit=3;
        $getAllEntries = $this->db->prepare("SELECT * FROM entries ORDER BY createdAt DESC LIMIT :limit");
        $getAllEntries->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $getAllEntries->execute();
        $allEntries = $getAllEntries->fetchAll();  
        return $allEntries;      
    }

    public function getOne($id)
    {
        $getOneEntry = $this->db->prepare("SELECT * FROM entries WHERE entryID = :id");
        $getOneEntry->execute([
          ":id" => $id
        ]);
        // Fetch -> single resource
        return $getOneEntry->fetch();
    }
    public function add($entry)
    {
            $addOne = $this->db->prepare(
            'INSERT INTO entries (title, content, createdBy, createdAt) 
            VALUES (:title, :content, :createdBy, :createdAt)'
        );

        /**
         * Insert the value from the parameter into the database
         */
        $addOne->execute(
       [':title'  => $entry['title'],
        ':content'  => $entry['content'],
        ':createdBy'  => $entry['createdBy'],
        ':createdAt'  => $entry['createdAt']]);

        /**
         * A INSERT INTO does not return the created object. If we want to return it to the user
         * that has posted the todo we must build it ourself or fetch it after we have inserted it
         * We can always get the last inserted row in a database by calling 'lastInsertId()'-function
         */
        return [
        'entryID'      => (int)$this->db->lastInsertId(),
        'title'  => $entry['title'],
        'content'  => $entry['content'],
        'createdBy'  => $entry['createdBy'],
        'createdAt'  => $entry['createdAt']
        ];
    }
    public function delete($id){
        $deleteOneEntry = $this->db->prepare("DELETE FROM entries WHERE entryID = :id");
        $deleteOneEntry->execute([
          ":id" => $id
        ]);
    }
    
}