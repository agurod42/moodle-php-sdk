<?php namespace MoodleSDK\Util;

use \zpt\anno\Annotations;
use MoodleSDK\Api\ModelBase;

class Reflection {

    public static function getPropertyGetter(ModelBase $object, $property) {
        foreach (get_class_methods($object) as $method) {
            if (strpos($method, 'get') === 0 && strtolower($method) === 'get'.strtolower($property)) {
                return $method;
            }
        }

        // if we didn't find any getter that could match the requested property then we throw an exception
        //throw new \Exception('object doesn\'t have a property getter for '.$property);
    }

    public static function getPropertySetter(ModelBase $object, $property) {
        foreach (get_class_methods($object) as $method) {
            if (strpos($method, 'set') === 0 && strtolower($method) === 'set'.strtolower($property)) {
                return $method;
            }
        }

        // if we didn't find any setter that could match the requested property then we throw an exception
        //throw new \Exception('object doesn\'t have a property setter for '.$property);
    }

    public static function getPropertyType(ModelBase $object, $property) {
        $type = self::getPropertyReturnAnnotation($object, $property);
        $type = str_replace('[]', '', $type);

        return new ReflectionType($type, $object);
    }

    private static function getPropertyReturnAnnotation(ModelBase $object, $property) {
        $method = self::getPropertyGetter($object, $property);
        $reflectionMethod = new \ReflectionMethod($object, $method);
        $annotations = new Annotations($reflectionMethod);

        if (!isset($annotations['return'])) {
            // if we didn't find any annotation specifying the property's return type then we throw an exception
            throw new \Exception('object property '.$property.' should have a return type (return annotation)');
        }

        return $annotations['return'];
    }

}