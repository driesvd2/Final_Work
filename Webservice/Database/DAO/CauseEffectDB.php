<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 22:02
 */

include_once "Models/Cause.php";
include_once "Models/Effect.php";
include_once "Models/Cause_Effect.php";
include_once "Database/DatabaseFactory.php";

class CauseEffectDB
{

    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getAll() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getEffectbyCauseId($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT effect FROM Cause_Effect WHERE cause=".$id);
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $databaseRij = EffectDB::getById($databaseRij['effect']);
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getCausebyEffectId($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect WHERE effect=".$id);
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


    public static function ifExists($causeid, $effectId){
        $mysqli = new mysqli("dt5.ehb.be", "1819FW_DRIESD_STEFANOSS", "DzwWqw", "1819FW_DRIESD_STEFANOSS");
        $result = $mysqli->query("SELECT * FROM Cause_Effect WHERE cause=".$causeid." AND effect=".$effectId);
        if($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
        $mysqli->close();
    }

    public static function insert($causeid, $effectId) {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Cause_Effect(cause, effect) VALUES ('$causeid','$effectId')");
    }

    public static function updateCause($causeid, $effectId) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cause_Effect SET cause=".$causeid." WHERE effect=".$effectId);
    }

    public static function updateEffect($effectId, $causeid) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cause_Effect SET effect=".$effectId." WHERE cause=".$causeid);
    }

    public static function deleteById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Cause_Effect WHERE id=".$id);
    }

    public static function deleteCauseById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Cause_Effect WHERE cause=".$id);
    }

    public static function deleteEffectById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Cause_Effect WHERE effect=".$id);
    }

    protected static function converteerRijNaarCauseEffect($databaseRij) {
        return new Cause_Effect($databaseRij['id'],$databaseRij['cause'], $databaseRij['effect']);
    }


    protected static function converteerRijNaarEffect($databaseRij) {
        return new Effect($databaseRij['id'], $databaseRij['name'], $databaseRij['status'], $databaseRij['Error_idError']);
    }

    protected static function converteerRijNaarCause($databaseRij) {
        return new Cause($databaseRij['id'], $databaseRij['name']);
    }
}