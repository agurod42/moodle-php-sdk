<?php namespace MoodleSDK\Api;

use MoodleSDK\Api\ApiContext;

interface ModelCRUD {

    function get(ApiContext $apiContext);

    function create(ApiContext $apiContext);
 
    function update(ApiContext $apiContext);

    function delete(ApiContext $apiContext);

}