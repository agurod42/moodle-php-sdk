<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ModelBase;

class Enrolment extends ModelBase {

    private $courseId;
    private $userId;
    private $roleId;
    private $timeStart;
    private $timeEnd;
    private $suspend;

    // Properties Getters & Setters

    public function getCourseId() {
        return $this->courseId;
    }

    public function setCourseId($courseId) {
        $this->courseId = $courseId;
        return $this;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function getRoleId() {
        return $this->roleId;
    }

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
        return $this;
    }

    public function getTimeStart() {
        return $this->timeStart;
    }

    public function setTimeStart($timeStart) {
        $this->timeStart = $timeStart;
        return $this;
    }

    public function getTimeEnd() {
        return $this->timeEnd;
    }

    public function setTimeEnd($timeEnd) {
        $this->timeEnd = $timeEnd;
        return $this;
    }

    public function getSuspend() {
        return $this->suspend;
    }

    public function setSuspend($suspend) {
        $this->suspend = $suspend;
        return $this;
    }
    
}