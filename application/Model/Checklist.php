<?php 

/**
 *
 * Class Checklist
 * 
**/

namespace Mini\Model;

use Mini\Core\Model;

class Checklist extends Model {

    public function getAllLists() {
        $sql = "SELECT l.id as id, l.name as taskName, l.last_change as changed, u.name as userName
                FROM lists as l
                INNER JOIN users as u
                ON l.user_id  = u.id
                WHERE l.active = '1'";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function addList($user_id, $listName) {
        $sql = "INSERT INTO lists (user_id, name)
                VALUES (:user_id, :name)";
        $query = $this->db->prepare($sql);
        $param = array(':user_id' => $user_id, ':name' => $listName);

        $query->execute($param);
    }

    public function getList($taskId) {
        $sql = "SELECT id, name, last_change as changed, user_id
                FROM lists
                WHERE active = '1'
                AND id = :taskId";
        $query = $this->db->prepare($sql);
        $param = array(':taskId' => $taskId);
        
        $query->execute($param);

        return $query->fetch();
    }

    public function getUserByList($userId) {
        $sql = "SELECT COUNT(l.id) as countLists, u.name as userName
                FROM lists as l
                INNER JOIN users as u
                ON l.user_id = u.id
                WHERE l.active = '1'
                AND l.user_id = :userId";
        $query = $this->db->prepare($sql);
        $param = array(':userId' => $userId);

        $query->execute($param);
        
        return $query->fetch();
    }

    public function updateList($listId, $newName) {
        $sql = "UPDATE lists
                SET name = :newName
                WHERE id = :listID";
        $query = $this->db->prepare($sql);
        $param = array(':newName' => $newName, ':listID' => $listId);

        $query->execute($param);
    }

    public function deleteList($listId) {
        $sql = "UPDATE lists 
                SET active = 0
                WHERE id = :listID";
        $query = $this->db->prepare($sql);
        $param = array(':listID' => $listId);

        $query->execute($param);
    }
}