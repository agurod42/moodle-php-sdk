<?php namespace MoodleSDK\Util;

use \zpt\anno\Annotations;
use MoodleSDK\Api\ModelBase;

class ReflectionType {

    const SCALAR_TYPES = ['boolean', 'integer', 'float', 'string'];

    private $name;
    private $namespace;
    
    public function __construct($name, $contextObject = null) {
        $this->name = $name;

        if (!$this->isScalar() && !$this->isClass()) {
            if ($contextObject) {
                $reflectionClass = new \ReflectionClass($contextObject);
                $namespace = $reflectionClass->getNamespaceName();
                $fullQualifiedName = $namespace.'\\'.$name;

                if (class_exists($fullQualifiedName)) {
                    $this->name = $name;
                    $this->namespace = $namespace;
                }
                else {
                    $err = true;
                }
            }
            else {
                $err = true;
            }
        }

        if (isset($err)) {
            throw new \Exception('Cannot resolve type '.$name);
        }
    }

    public function __toString() {
        return $this->getFullName();
    }

    public function isClass() {
        return class_exists($this->name);
    }

    public function isScalar() {
        return in_array($this->name, self::SCALAR_TYPES);
    }

    public function newInstance() {
        if ($this->isScalar()) {
            throw new Exception('Only non-scalar types instance can be created');
        }

        $instance = new \ReflectionClass($this->getFullName());
        return $instance->newInstanceArgs(func_get_args());
    }

    // Properties Getters & Setters

    public function getFullName() {
        return ltrim($this->namespace.'\\'.$this->name, '\\');
    }

}