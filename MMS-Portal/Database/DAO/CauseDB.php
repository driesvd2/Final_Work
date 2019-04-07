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
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getById($id) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause WHERE idCause=" .$id);
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchCause($searchq) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Cause where CauseName LIKE '%$searchq%'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchCauseID($searchq) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select idCause from Cause where CauseName LIKE '%$searchq%'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


    public static function insert($cause) {
    return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Cause(idCause, CauseName) VALUES (null ,'$cause')");
}

    public static function deleteCauseById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Cause WHERE idCause=".$id);
    }

    public static function delete($cause) {
        return self::deleteById($cause->idCause);
    }

    public static function update($causename,$id) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cause SET CauseName='$causename' WHERE idCause= $id");
    }

    protected static function converteerRijNaarCause($databaseRij) {
        return new Cause($databaseRij['idCause'], $databaseRij['CauseName']);
    }
}
?>