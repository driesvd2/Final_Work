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

    public static function getAllColumnsOfCauseEffect() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT column_name FROM information_schema.columns WHERE table_schema = '1819FW_DRIESD_STEFANOSS' AND table_name = 'Cause_Effect'");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
                $result = $resultaat->fetch_array();
                $resultatenArray[$index] = $result["column_name"];
            }
        return $resultatenArray;
    }
     
    public static function getAllMetaColumnsOfCauseEffect() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT column_name FROM information_schema.columns WHERE table_schema = '1819FW_DRIESD_STEFANOSS' AND table_name = 'Cause_Effect' AND column_name != 'id' AND column_name != 'cause' AND column_name != 'effect'");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
                $result = $resultaat->fetch_array();
                $resultatenArray[$index] = $result["column_name"];
            }
        return $resultatenArray;
    }
     
    public static function addColumnCauseEffect($name) {
        return self::getVerbinding()->voerSqlQueryUit('ALTER TABLE Cause_Effect ADD '.$name.' VARCHAR(1500) NULL');
    }

    public static function deleteColumnCauseEffect($name) {
        return self::getVerbinding()->voerSqlQueryUit('ALTER TABLE Cause_Effect DROP COLUMN '.$name);
    }

    public static function editColumnCauseEffect($old, $name)
    {
        return self::getVerbinding()->voerSqlQueryUit('ALTER TABLE Cause_Effect Change COLUMN ' . $old . ' ' . $name . ' VARCHAR(1500) ');
    }

    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getAll() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getByIdMeta($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect WHERE id=".$id." ORDER BY id ASC");
        $result = $resultaat->fetch_array();
        return $result;
    }
 
    public static function getCauseEffects($array) {
        $query = "SELECT * FROM Cause_Effect WHERE ";
        foreach ($array as $a) {
            $query .= "effect=".$a." OR ";
        }
        $query .= " 1=2 ORDER BY effect ASC";
        $resultaat = self::getVerbinding()->voerSqlQueryUit($query);
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function ifExists($causeid, $effect, $id){
        $mysqli = new mysqli("dt5.ehb.be", "1819FW_DRIESD_STEFANOSS", "DzwWqw", "1819FW_DRIESD_STEFANOSS");
        $result = $mysqli->query("SELECT id FROM Cause_Effect WHERE cause=".$causeid." AND effect=".$effect." ORDER BY id ASC");
        $resultaat = $result->fetch_array();
        if($result->num_rows == 0 || $resultaat['id'] == $id) {
            return false;
        } else {
            return true;
        }
        $mysqli->close();
    }
    
    public static function ifExistsInsert($causeid, $effectId){
        $mysqli = new mysqli("dt5.ehb.be", "1819FW_DRIESD_STEFANOSS", "DzwWqw", "1819FW_DRIESD_STEFANOSS");
        $result = $mysqli->query("SELECT * FROM Cause_Effect WHERE cause=".$causeid." AND effect=".$effectId . " ORDER BY id ASC");
        if($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
        $mysqli->close();
    }
  
    public static function getCausebyEffectId($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect WHERE id=".$id . " ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
     
    public static function getCausebyEffectIdOne($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect WHERE effect=".$id . " ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getCauseEffectbyCauseForDelete($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect WHERE cause=".$id . " ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getCauseEffectWhereIdCause($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect WHERE cause=".$id . " ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getCauseEffectWhereIdEffect($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect WHERE effect=".$id . " ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
                                                            
    public static function getSearchCauseOfCauseEffect($searchq, $column) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause_Effect where ".$column." LIKE '%$searchq%' ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


    public static function insert($causeid, $effectId) {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Cause_Effect(cause, effect) VALUES ('$causeid','$effectId')");
    }

    public static function updateCauseEffectEntity($array,$id) {
        $query = "UPDATE Cause_Effect SET ";
    foreach ($array as $key => $value) {
        $query .= " ".$key." = '$value', ";
    }
    $query = substr($query, 0, -2);
               

    $query .= " where id =".$id;
        
        
        
        return self::getVerbinding()->voerSqlQueryUit($query);
    }
    

    public static function deleteById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Cause_Effect WHERE id=".$id);
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