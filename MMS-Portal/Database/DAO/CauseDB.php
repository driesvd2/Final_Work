<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 18:42
 */


include_once "Models/Cause.php";
include_once "Database/DatabaseFactory.php";

class CauseDB {

    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getAll() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
      
    
    public static function getAllColumnsOfCause() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT column_name FROM information_schema.columns WHERE table_schema = '1819FW_DRIESD_STEFANOSS' AND table_name = 'Cause'");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
                $result = $resultaat->fetch_array();
                $resultatenArray[$index] = $result["column_name"];
            }
        return $resultatenArray;
    }
    
    

    
    public static function getAllMetaColumnsOfCause() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT column_name FROM information_schema.columns WHERE table_schema = '1819FW_DRIESD_STEFANOSS' AND table_name = 'Cause' AND column_name != 'id' AND column_name != 'name'");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
                $result = $resultaat->fetch_array();
                $resultatenArray[$index] = $result["column_name"];
        }
        return $resultatenArray;
    }
    
    public static function getByIdMeta($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause WHERE id=".$id." ORDER BY id ASC");
        $result = $resultaat->fetch_array();
        return $result;
    }
    
    
    
    public static function addColumnCause($name) {
        return self::getVerbinding()->voerSqlQueryUit('ALTER TABLE Cause ADD '.$name.' VARCHAR(1500) NULL');
    }

    public static function deleteColumnCause($name) {
        return self::getVerbinding()->voerSqlQueryUit('ALTER TABLE Cause DROP COLUMN '.$name);
    }
    

    public static function getById($id) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause WHERE id=" .$id." ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchCause($searchq,$column) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Cause where ".$column." LIKE '%$searchq%' ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchCauseID($searchq) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select id from Cause where name LIKE '%$searchq%' ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
 

    public static function insert($cause) {
    return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Cause(id, name) VALUES (null ,'$cause')");
    }

    public static function deleteCauseById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Cause WHERE id=".$id);
    }

    public static function update($array, $id) {
        $query = "UPDATE Cause SET ";
    foreach ($array as $key => $value) {
        $query .= " ".$key." = '$value', ";
    }
    $query = substr($query, 0, -2);
               

    $query .= " where id =".$id;
        
        
        
        return self::getVerbinding()->voerSqlQueryUit($query);
    }

    protected static function converteerRijNaarCause($databaseRij) {
        return new Cause($databaseRij['id'], $databaseRij['name']);
    }
}
?>