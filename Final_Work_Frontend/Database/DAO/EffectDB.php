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




    public static function insert($effect) {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO Effect(idEffect, EffectName, EffectDescription) VALUES ('?','?','?')", array($effect->idEffect, $effect->EffectName, $effect->EffectDescription));
    }

    public static function deleteById($id) {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM Effect WHERE idEffect=".$id);
    }

    public static function delete($effect) {
        return self::deleteById($effect->idEffect);
    }

    public static function update($effect) {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE Effect SET EffectName='?',EffectDescription='?' WHERE idEffect='?'", array($effect->EffectName, $effect->EffectDescription, $effect->idEffect));
    }

    protected static function converteerRijNaarEffect($databaseRij) {
        return new Effect($databaseRij['idEffect'], $databaseRij['EffectName'], $databaseRij['EffectDescription']);
    }

}
?>