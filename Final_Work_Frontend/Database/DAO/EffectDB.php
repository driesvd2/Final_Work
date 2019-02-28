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
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where EffectStatus != 0");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getAllHasCause() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where EffectStatus=2");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllQueue() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect where EffectStatus=0 OR EffectStatus=1");
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
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Effect WHERE idEffect=" .$id);
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function setStatus0($effectId) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET EffectStatus=0 WHERE idEffect=".$effectId);
    }

    public static function setStatus1($effectId) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET EffectStatus=1 WHERE idEffect=".$effectId);
    }

    public static function setStatus2($effectId) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET EffectStatus=2 WHERE idEffect=".$effectId);
    }


    public static function insert($effectName) {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Effect(idEffect, EffectName, EffectStatus, Error_idError) VALUES (null ,'$effectName', 1, null)");
    }

    public static function insertNewEffect($effectname, $effectstatus){
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Effect(idEffect,EffectName, EffectStatus, Error_idError) VALUES (null, '$effectname',$effectstatus,null)");
    }

    public static function deleteById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Effect WHERE idEffect=".$id);
    }


    public static function delete($effect) {
        return self::deleteById($effect->idEffect);
    }

    public static function update($effect) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET EffectName='?' WHERE idEffect='?'", array($effect->EffectName, $effect->idEffect));
    }
    public static function updateEffect($ideffect,$effectname,$effectstatus) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET EffectName='$effectname', EffectStatus='$effectstatus' WHERE idEffect=$ideffect");
    }

    protected static function converteerRijNaarEffect($databaseRij) {
        return new Effect($databaseRij['idEffect'], $databaseRij['EffectName'], $databaseRij['EffectStatus'], $databaseRij['Error_idError']);
    }

}
?>