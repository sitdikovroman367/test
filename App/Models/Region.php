<?php

namespace App\Models;

use PDO;


class Region extends \Core\Model
{

    public static function getObl()
    {
        $db = static::getDB();
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

        $stm = $db->prepare('SELECT * FROM `t_koatuu_tree` WHERE ter_type_id = 0 ORDER BY ter_name ASC ');
        $stm->execute();

        if (!$stm) {
            echo "\nPDO::errorInfo():\n";
            print_r($db->errorInfo());
        }
        return  $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTerByPid($ter_pid)
    {
        $db = static::getDB();
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $sql = 'SELECT * FROM `t_koatuu_tree` WHERE ter_pid = ?';
        $stm = $db->prepare($sql);
        $stm->bindValue(1, $ter_pid, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getTerByID($ter_id) {
        $dbh = static::getDB();
        $stmt = $dbh->prepare("SELECT * FROM `t_koatuu_tree` WHERE ter_id= ".(int)$ter_id." LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

}
