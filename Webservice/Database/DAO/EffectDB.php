<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 21:48
 */

include_once "Models/Effect.php";
include_once "Database/DatabaseFactory.php";

class EffectDB
{

    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getAll() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllWhereStatusIsNot0() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where status != 0");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getAllHasCause() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where status=2");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllQueue() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where status=0 OR status=1");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getAllStatusZero() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where status=0");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getAllStatusOne() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where status=1");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getById($id) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect WHERE id=" .$id);
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getIdByEffectName($effect) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect WHERE name LIKE '%$effect%'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchEffect($searchq) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Effect where name LIKE '%$searchq%'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchEffectWhereStatusNotZero($searchq) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Effect where name LIKE '%$searchq%' AND status != 0");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function ifExists($effect){
        //$mysqli = new mysqli("dt5.ehb.be", "1819FW_DRIESD_STEFANOSS", "DzwWqw", "1819FW_DRIESD_STEFANOSS");
        $result = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect WHERE name LIKE '%$effect%'");
        if($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function setStatus0($effectId) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET status=0 WHERE id=".$effectId);
    }

    public static function setStatus1($effectId) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET status=1 WHERE id=".$effectId);
    }

    public static function setStatus2($effectId) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET status=2 WHERE id=".$effectId);
    }


    public static function insert($effectName) {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Effect(id, name, status, Error_idError) VALUES (null ,'$effectName', 1, null)");
    }

    public static function insertNewEffect($effectname, $effectstatus){
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Effect(id,name, status, tag) VALUES (null, '$effectname',$effectstatus,null)");
    }

    public static function deleteById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Effect WHERE id=".$id);
    }


    public static function delete($effect) {
        return self::deleteById($effect->id);
    }

    public static function update($effect) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET name='?' WHERE id='?'", array($effect->name, $effect->id));
    }
    public static function updateEffect($ideffect,$effectname,$effectstatus) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET name='$effectname', status='$effectstatus' WHERE id=$ideffect");
    }

    protected static function converteerRijNaarEffect($databaseRij) {
        return new Effect($databaseRij['id'], $databaseRij['name'], $databaseRij['status']);
    }

}
?>