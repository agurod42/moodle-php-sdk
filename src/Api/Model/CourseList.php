<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBaseList;

class CourseList extends ModelBaseList {

    public function all(ApiContext $apiContext) {
        $json = $this->apiCall($apiContext, 'core_course_get_courses', [
            'options' => [
                'ids' => [
                ]
            ]
        ]);

        $this->fromJSON($json);
        return $this;
    }

    public function searchByUser(ApiContext $apiContext, User $user) {
        $json = $this->apiCall($apiContext, 'core_enrol_get_users_courses', [
            'userid' => $user->getId()
        ]);

        $this->fromJSON($json);
        return $this;
    }

}