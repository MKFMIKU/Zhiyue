<?php
/**
 * Created by PhpStorm.
 * User: meikangfu
 * Date: 2017/11/4
 * Time: 下午9:57
 */

namespace models;
use PDO;
use PDOException;
use lib\Core;

/**
 * Class User
 */
Class User{
    private $_select =
        "SELECT * FROM Users ";
    private $_insert =
        "INSERT INTO Users(username, avatar_url, school, bio, pass)  VALUES(:username, :avatar_url, :school, :bio, :pass)";
    private $_update =
        "UPDATE Users SET username = :username, avatar_url = :avatar_url, school = :school, bio = :bio WHERE id = :id";
    private $_delete =
        "DELETE FROM Users WHERE id = :id";

    protected $core;
    function __construct() {
        $this->core = Core::getInstance();
    }


    /**
     * Get All users
     */
    public function getAll(){
        $sql = $this->_select . " ORDER BY username";
        try {
            $stmt = $this->core->dbconn->prepare($sql);
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return json_encode($result);
        } catch(PDOException $e) {
            return '{"error":{"msg":'. $e->getMessage() .'}}';
        }
    }

    /**
     * @param $username
     * Get user detail by username
     * @return string
     */
    public function getByUsername($username){
        $sql = $this->_select . " WHERE username LIKE :username ORDER BY username";
        try {
            $stmt = $this->core->dbconn->prepare($sql);
            $name = "%".$username."%";
            $stmt->bindParam("name", $name);
            $stmt->execute();
            $result = $stmt->fetchObject(PDO::FETCH_OBJ);
            return json_encode($result);
        } catch(PDOException $e) {
            return '{"error":{"msg":'. $e->getMessage() .'}}';
        }
    }

    /**
     * @param $id
     * Get user detail by id
     * @return string
     */
    public function getById($id){
        $sql = $this->_select . " WHERE id = :id ORDER BY username";
        try {
            $stmt = $this->core->dbconn->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $result = $stmt->fetchObject();
            return json_encode($result);
        } catch(PDOException $e) {
            return '{"error":{"msg":'. $e->getMessage() .'}}';
        }
    }

    /**
     * @param $school
     * Get users by school
     * @return string
     */
    public function getBySchool($school){
        $sql = $this->_select . " WHERE school = :$school ORDER BY username";
        try {
            $stmt = $this->core->dbconn->prepare($sql);
            $stmt->bindParam("school", $school);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return json_encode($result);
        } catch(PDOException $e) {
            return '{"error":{"msg":'. $e->getMessage() .'}}';
        }
    }

    /**
     * @param $vo
     * Add new user
     * @return string
     */
    public function insert($vo){
        $sql = $this->_insert;
        try {
            $stmt = $this->core->dbconn->prepare($sql);
            $stmt->bindParam("username", $vo->username);
            $stmt->bindParam("avatar_url", $vo->avatar_url);
            $stmt->bindParam("school", $vo->school);
            $stmt->bindParam("bio", $vo->bio);
            $stmt->bindParam("pass", $vo->pass);
            $stmt->execute();
            $vo->id = $this->core->dbconn->lastInsertId();
            return json_encode($vo);
        } catch(PDOException $e) {
            return '{"error":{"msg":'. $e->getMessage() .'}}';
        }
    }

    /**
     * @param $vo
     * Update user detail
     * @return string
     */
    public function update($vo){
        $sql = $this->_update;
        try {
            $stmt = $this->core->dbconn->prepare($sql);
            $stmt->bindParam("username", $vo->username);
            $stmt->bindParam("avatar_url", $vo->avatar_url);
            $stmt->bindParam("school", $vo->school);
            $stmt->bindParam("bio", $vo->bio);
            $stmt->execute();
            $db = null;
            return json_encode($vo);
        } catch(PDOException $e) {
            return '{"error":{"msg":'. $e->getMessage() .'}}';
        }
    }

    /**
     * @param $id
     * Delete a user by id
     */
    public function delete($id){
        $sql = $this->_delete;
        try {
            $stmt = $this->core->dbconn->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $db = null;
            echo 'ok';
        } catch(PDOException $e) {
            echo '{"error":{"msg":'. $e->getMessage() .'}}';
        }
    }

}