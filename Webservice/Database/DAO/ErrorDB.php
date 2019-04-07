<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 21:54
 */

include_once "Models/ErrorClass.php";
include_once "Database/DatabaseFactory.php";

class ErrorDB
{
    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getAll() {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Error");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarError($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getById($id) {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM Error WHERE idError=" .$id);
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarError($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }




    public static function insert($error) {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Error(idError, Message) VALUES ('?','?')", array($error->idError, $error->Message));
    }

    public static function deleteById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Error WHERE idError=".$id);
    }

    public static function delete($error) {
        return self::deleteById($error->idError);
    }

    public static function update($error) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Error SET Message='?' WHERE idError='?'", array($error->Message, $error->idError));
    }

    protected static function converteerRijNaarError($databaseRij) {
        return new ErrorClass($databaseRij['idError'], $databaseRij['Message']);
    }
}