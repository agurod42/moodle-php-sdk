<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ModelBase;

class UserList extends ModelBase {

    private $users;
    private $warnings;

    // Properties Getters & Setters

    /**
     * @return User[]
     */
    public function getUsers() {
        return $this->users;
    }

    public function setUsers($users) {
        $this->users = $users;
    }
    
    /**
     * @return string[]
     */
    public function getWarnings() {
        return $this->warnings;
    }

    public function setWarnings($warnings) {
        $this->warnings = $warnings;
    }

}