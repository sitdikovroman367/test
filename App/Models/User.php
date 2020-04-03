<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
    public static function getUserByID($userId) {
        $dbh = static::getDB();
        $stmt = $dbh->prepare("SELECT * FROM user WHERE id= ".(int)$userId." LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function createUser($fio, $email, $ter_id) {
        $dbh = static::getDB();
        $allowed = array("fio","email","ter_id");
        $values = [$fio, $email, $ter_id];
        $sql = "INSERT INTO user (fio, email, ter_id) VALUES (?, ? ,?)";
        $stm = $dbh->prepare($sql);
        $stm->execute($values);
        return $dbh->lastInsertId();
    }

    public static function existByEmail($email) {
        $dbh = static::getDB();
        $stmt = $dbh->prepare("SELECT * FROM user WHERE email= ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
