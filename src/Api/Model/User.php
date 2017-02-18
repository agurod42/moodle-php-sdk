<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBase;

class User extends ModelBase {

    private $id;
    private $username;
    private $firstName;
    private $lastName;
    private $fullName;
    private $preferences;

    public function create() {
        
    }

    public function all(ApiContext $apiContext) {
        $json = $this->apiCall($apiContext, 'core_user_get_users', [
            'criteria' => [
                [
                    'key' => 'string',
                    'value' => 'string'
                ]
            ]
        ]);

        $list = new UserList();
        $list->fromJSON($json);
        return $list;
    }

    // Properties Getters & Setters

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName() {
        return $this->LastName;
    }

    public function setLastName($LastName) {
        $this->LastName = $LastName;
        return $this;
    }

    public function getFullName() {
        return $this->FullName;
    }

    public function setFullName($FullName) {
        $this->FullName = $FullName;
        return $this;
    }

    /**
     * @return UserPreference[]
     */
    public function getPreferences() {
        return $this->preferences;
    }

    public function setPreferences($preferences) {
        $this->preferences = $preferences;
        return $this;
    }

}