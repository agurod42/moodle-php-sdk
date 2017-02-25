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


    public function setWarnings($warnings) {
        $this->warnings = $warnings;
        return $this;
    }

}