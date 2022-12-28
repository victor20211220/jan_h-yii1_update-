<?php
class DbAuthManager extends CDbAuthManager {
    public function revokeAll($userId) {
        return $this->db->createCommand()
            ->delete($this->assignmentTable, 'userid=:userid', array(
                ':userid'=>$userId
            )) > 0;
    }
}