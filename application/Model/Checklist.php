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

    public function lastEditList($listId) {
        $sql = "UPDATE lists
                SET last_change = :lastChanged
                WHERE id = :listId";
        $query = $this->db->prepare($sql);
        $param = array(':lastChanged' => time(), ':listId' => $listId);

        $query->execute($param);
    }

    public function deleteList($listId) {
        $sql = "UPDATE lists 
                SET active = 0
                WHERE id = :listId";
        $query = $this->db->prepare($sql);
        $param = array(':listId' => $listId);

        $query->execute($param);
    }

    public function getTasksByList($listId) {
        $sql = "SELECT t.id, t.name as taskName, t.description, t.duration, ts.name as status, u.name as userName
                FROM tasks as t
                INNER JOIN task_status as ts
                ON t.status = ts.id
                INNER JOIN users as u
                ON t.user_id = u.id
                WHERE t.active = 1
                AND t.list_id = :listId";
        $query = $this->db->prepare($sql);
        $param = array(':listId' => $listId);

        $query->execute($param);

        return $query->fetchAll();
    }

    public function addTask($listId, $userId, $taskName, $taskDescription, $taskDuration) {
        $sql = "INSERT INTO tasks (list_id, user_id, name, description, duration)
                VALUES (:listId, :userId, :taskName, :taskDescription, :taskDuration)";
        $query = $this->db->prepare($sql);
        $param = array( ':listId' => $listId,
                        ':userId' => $userId,
                        ':taskName' => $taskName,
                        ':taskDescription' => $taskDescription,
                        ':taskDuration' => $taskDuration);
        
        $query->execute($param);
    }

    public function getTask($taskId) {
        $sql = "SELECT t.id as id, l.id as listId, l.name as listName, t.name as taskName, t.description, t.duration, ts.name as status, t.status as numStatus
                FROM tasks as t
                INNER JOIN lists as l
                ON t.list_id = l.id
                INNER JOIN users as u
                ON t.user_id = u.id
                INNER JOIN task_status as ts
                ON t.status = ts.id
                WHERE t.active = 1
                AND t.id = :taskId";
        $query = $this->db->prepare($sql);
        $param = array(':taskId' => $taskId);

        $query->execute($param);

        return $query->fetch();
    }

    public function updateTask($taskId, $taskName, $taskDescription, $taskDuration, $taskStatus) {
        $sql = 'UPDATE tasks
                SET name = :taskName, description = :taskDescription, duration = :taskDuration, status = :taskStatus
                WHERE id = :taskId';
        $query = $this->db->prepare($sql);
        $param = array( ':taskName' => $taskName,
                        ':taskDescription' => $taskDescription,
                        ':taskDuration' => $taskDuration,
                        ':taskStatus' => $taskStatus,
                        ':taskId' => $taskId);
        
        $query->execute($param);
    }

    public function deleteTask($taskId) {
        $sql = "UPDATE tasks 
                SET active = 0
                WHERE id = :taskId";
        $query = $this->db->prepare($sql);
        $param = array(':taskId' => $taskId);

        $query->execute($param);
    }
}