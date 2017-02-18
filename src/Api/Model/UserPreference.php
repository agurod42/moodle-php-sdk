<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ModelBase;

class UserPreference extends ModelBase {

    private $users;

    // Properties Getters & Setters

    public function getUsers() {
        return $this->users;
    }

    public function setUsers($users) {
        $this->users = $users;
        return $this;
    }

}