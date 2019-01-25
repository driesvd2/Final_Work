<?php
/**
 * Created by PhpStorm.
 * User: dries
 * Date: 24/01/2019
 * Time: 22:02
 */

include_once "Models/Cause.php";
include_once "Models/Effect.php";
include_once "Database/DatabaseFactory.php";

class CauseEffectDB
{

    public static function getAllEffectsbyCauseId($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT Effect_idEffect FROM Cause_Effect WHERE Cause_idCause=".$id);
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $databaseRij = EffectDB::getById($databaseRij['Effect_idEffect']);
            $nieuw = self::converteerRijNaarEffect($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllCausesbyEffectId($id) {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT Cause_idCause FROM Cause_Effect WHERE Effect_idEffect=".$id);
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $databaseRij = CauseDB::getById($databaseRij['Cause_idCause']);
            $nieuw = self::converteerRijNaarCause($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    protected static function converteerRijNaarEffect($databaseRij) {
        return new Effect($databaseRij['idEffect'], $databaseRij['EffectName'], $databaseRij['EffectDescription']);
    }

    protected static function converteerRijNaarCause($databaseRij) {
        return new Cause($databaseRij['idCause'], $databaseRij['CauseName'], $databaseRij['CauseDescription']);
    }
}