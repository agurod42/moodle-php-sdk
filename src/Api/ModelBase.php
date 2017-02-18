<?php namespace MoodleSDK\Api;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Util\Reflection;

class ModelBase {

    public function __construct() {
    }

    public function apiCall(ApiContext $apiContext, $method = '', $payload = null) {
        $call = $apiContext->newCall($method, $payload);
        $response = $call->execute();
        return $response;
    }

    public function fromArray($data) {
        foreach ($data as $k => $v) {

            if (is_array($v)) {
                $itemType = Reflection::getPropertyType($this, $k);
                $items = [];

                foreach ($v as $v_i) {
                    if ($itemType->isScalar()) {
                        $items[] = $v_i;
                    }
                    else {
                        $item = $itemType->newInstance();
                        $item->fromArray($v_i);
                        $items[] = $item;
                    }
                }

                $method = Reflection::getPropertySetter($this, $k);
                $this->{$method}($items);
            }
            else {
                $method = Reflection::getPropertySetter($this, $k);
                if ($method) {
                    $this->{$method}($v);
                }
            }

        }
    }

    public function fromJSON($data) {
        $this->fromArray(json_decode($data));
    }

    public function toArray() {
        return '';
    }

    public function toJSON() {
        return json_encode($this->toArray());
    }

}