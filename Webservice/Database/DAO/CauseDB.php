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
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Cause WHERE id=" .$id);
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchCause($searchq) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from Cause where name LIKE '%$searchq%'");
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

    public static function delete($cause) {
        return self::deleteById($cause->id);
    }

    public static function update($causename,$id) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Cause SET name='$causename' WHERE id= $id");
    }

    protected static function converteerRijNaarCause($databaseRij) {
        return new Cause($databaseRij['id'], $databaseRij['name']);
    }
}
?>