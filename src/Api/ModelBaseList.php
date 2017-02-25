<?php namespace MoodleSDK\Api;

abstract class ModelBaseList extends ModelBase implements \ArrayAccess, \Countable {

    protected $list = [];

    public abstract function all(ApiContext $apiContext);

    // ArrayAccess Methods

    public function offsetExists($offset) {
        return isset($this->list[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->list[$offset]) ? $this->list[$offset] : null;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->list[] = $value;
        }
        else {
            $this->list[$offset] = $value;
        }
    }

    public function offsetUnset($offset) {
        unset($this->list[$offset]);
    }

    // Countable Methods

    public function count() {
        return count($this->list);
    }

}