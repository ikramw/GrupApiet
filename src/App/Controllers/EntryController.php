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
    public function getByUser($userId)
    {
        $getEntryByUser = $this->db->prepare("SELECT * FROM entries WHERE createdBy = :id");
        $getEntryByUser->execute([
          ":id" => $userId
        ]);
        return $getEntryByUser->fetchAll();
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
    public function update($id)
    {
        $updateOne = $this->db->prepare(
        'UPDATE entries 
        SET title = :title, content = :content,
        createdBy = :createdBy, createdAt = :createdAt
        WHERE entryID = :id'
    
        );
        $updateOne->execute(
       [":id" => $id,
        ':title'  => $_POST['title'],
        ':content'  => $_POST['content'],
        ':createdBy'  => $_POST['createdBy'],
        ':createdAt'  => $_POST['createdAt']]);

        /**
         * A INSERT INTO does not return the created object. If we want to return it to the user
         * that has posted the todo we must build it ourself or fetch it after we have inserted it
         * We can always get the last inserted row in a database by calling 'lastInsertId()'-function
         */
        return [
        'createdBy'  => $_POST['createdBy'],
        'createdAt'  => $_POST['createdAt']
        ];
    }
}
