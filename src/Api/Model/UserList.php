<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBaseList;

class UserList extends ModelBaseList {

    public function all(ApiContext $apiContext) {
        $json = $this->apiCall($apiContext, 'core_user_get_users', [
            'criteria' => [
                [
                    'key' => 'string',
                    'value' => 'string'
                ]
            ]
        ]);

        $this->fromJSON($json);
        return $this;
    }

}