<?php
/**
 * Created by PhpStorm.
 * User: meikangfu
 * Date: 2017/11/5
 * Time: 上午12:30
 */

namespace lib;
use PDO;

/**
 * Class Core
 */
class Core {
    public $dbconn;
    private static $instance;

    private function __construct() {
        $dataSource = 'mysql:host=' . Config::read('db.host') .
            ';dbname=' . Config::read('db.name');
        $user = Config::read('db.user');
        $pass = Config::read('db.pass');

        $this->dbconn = new PDO($dataSource, $user, $pass);
    }

    public static function getInstance() {
        if (!isset(self::$instance)){
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }
}