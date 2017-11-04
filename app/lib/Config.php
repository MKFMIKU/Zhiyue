<?php

namespace lib;

/**
 * Class Config
 * @package lib
 */
class Config {
    static $confArray;

    /**
     * @param $name
     * @return mixed
     */
    public static function read($name)
    {
        if(isset(self::$confArray[APPLICATION_ENV][$name])){
            return self::$confArray[APPLICATION_ENV][$name];
        }
        return self::$confArray['local'][$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public static function write($name, $value)
    {
        self::$confArray[APPLICATION_ENV][$name] = $value;
    }
}