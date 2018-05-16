<?php

namespace App\Controllers;

class EntryController
{
    private $db;
    
    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAll($params){
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
    public function getByTitle($title)
    {
        $getEntryByTitle = $this->db->prepare("SELECT * FROM entries WHERE title = :title");
        $getEntryByTitle->execute([
          ":title" => $title
        ]);
        return $getEntryByTitle->fetch();
    }
    public function add($entry)
    {
            $addOne = $this->db->prepare(
            'INSERT INTO entries (title, content, createdBy, createdAt) 
            VALUES (:title, :content, :createdBy, :createdAt)'
        );
       
        $addOne->execute(
       [':title'  => $entry['title'],
        ':content'  => $entry['content'],
        ':createdBy'  => $entry['createdBy'],
        ':createdAt'  => $entry['createdAt']]);

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
    public function update($entry,$id)
    {
        $updateOne = $this->db->prepare(
        'UPDATE entries 
        SET title = :title, content = :content,
        createdBy = :createdBy, createdAt = :createdAt
        WHERE entryID = :id'
    
        );
        $updateOne->execute(
       [":id" => $id,
        ':title'  => $entry['title'],
        ':content'  => $entry['content'],
        ':createdBy'  => $entry['createdBy'],
        ':createdAt'  => $entry['createdAt']]);

        return [
        ':title'  => $entry['title'],
        ':content'  => $entry['content'],
        'createdBy'  => $entry['createdBy'],
        'createdAt'  => $entry['createdAt']
        ];
    }
}
