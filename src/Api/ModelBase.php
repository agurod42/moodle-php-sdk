<?php namespace MoodleSDK\Api;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Util\Reflection;

abstract class ModelBase {

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

    public function fromObject($object) {
        $this->fromArray((array)$object);
    }

    public function toArray() {
        $arr = [];

        Reflection::forEachGetter($this, function($method) use (&$arr) {
            $k = strtolower(substr($method, 3));

            if (!method_exists($this, 'toArrayExcludedProperties') || !in_array($k, $this->toArrayExcludedProperties())) {
                $v = $this->{$method}();
                $arr[$k] = $this->valueToArray($v);
            }
        });

        return $arr;
    }

    private function valueToArray($value) {
        if (is_array($value)) {
            $arr = [];
            foreach($value as $k => $v) {
                $arr[$k] = $this->valueToArray($v);
            }
            return $arr;
        }
        else if ($value instanceof ModelBase) {
            return $value->toArray();
        }
        else {
            return $value;
        }
    }

    public function toJSON() {
        return json_encode($this->toArray());
    }

}