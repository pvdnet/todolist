<?php 

/**
 *
 * Class List
 * 
**/

namespace Mini\Model;

use Mini\Core\Model;

class Task extends Model {

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

}