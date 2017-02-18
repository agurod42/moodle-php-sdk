<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ModelBaseList;

class UserList extends ModelBaseList {

    private $warnings;

    // Properties Getters & Setters

    /**
     * @return User[]
     */
    public function getUsers() {
        return $this->list;
    }

    public function setUsers($users) {
        $this->list = $users;
        return $this;
    }
    
    /**
     * @return string[]
     */
    public function getWarnings() {
        return $this->warnings;
    }

    public function setWarnings($warnings) {
        $this->warnings = $warnings;
        return $this;
    }

}