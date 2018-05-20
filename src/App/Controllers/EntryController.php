<?php

namespace App\Controllers;

class EntryController
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }
    public function getDefault(){
        $limit=20;
        $getAllEntries = $this->db->prepare("SELECT entries.entryID, entries.title,
        entries.content,entries.createdBy,entries.createdAt , users.username 
        FROM entries INNER JOIN users ON userID=createdBy 
        ORDER BY createdAt DESC LIMIT :limit");
        $getAllEntries->bindParam(':limit', $limit , \PDO::PARAM_INT);
        $getAllEntries->execute();
        $allEntries = $getAllEntries->fetchAll();
        return $allEntries;
    }
    public function getAll(){

        $getAllEntries = $this->db->prepare("SELECT entries.entryID, entries.title,
        entries.content,entries.createdBy,entries.createdAt , users.username 
        FROM entries INNER JOIN users ON userID=createdBy
        ORDER BY createdAt DESC LIMIT :limit");
        $getAllEntries->bindParam(':limit', $_GET['limit'] , \PDO::PARAM_INT);
        $getAllEntries->execute();
        $allEntries = $getAllEntries->fetchAll();
        return $allEntries;
    }

    public function getOne($id)
    {
        $getOneEntry = $this->db->prepare("SELECT entries.entryID, entries.title,
        entries.content,entries.createdBy,entries.createdAt , users.username 
        FROM entries 
        INNER JOIN users ON userID=createdBy
        WHERE entryID = :id");
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
    public function getByTitle()
    {
        $getEntryByTitle = $this->db->prepare("SELECT entries.entryID, entries.title,
        entries.content,entries.createdBy,entries.createdAt , users.username 
        FROM entries INNER JOIN users ON userID=createdBy WHERE title = :title");
        $getEntryByTitle->bindParam(':title', $_GET['title'] , \PDO::PARAM_STR, 12);
        $getEntryByTitle->execute();
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
