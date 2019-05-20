<?php

include_once "Models/Effect.php";
include_once "Models/Tag.php";
include_once "Database/DatabaseFactory.php";

class EffectTagDB
{
    private static function getVerbinding()
    {
        return DatabaseFactory::getDatabase();
    }

    public static function ifLast($id)
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM EffectTag WHERE parent = '$id' ORDER BY id ASC");
        $resultatenArray = array();
        if ($resultaat->num_rows > 0) {
            return false;
        }else{
            return true;
        }
    }

    public static function getAll()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM EffectTag ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffectTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllFirst(){
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM EffectTag WHERE parent IS null ORDER BY name ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffectTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllSecond(){
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM EffectTag WHERE parent in (SELECT id FROM EffectTag WHERE parent IS null)");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffectTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllThird(){
        $resultaat = self::getVerbinding()->voerSqlQueryUit("Select * from EffectTag where parent in (SELECT id FROM EffectTag WHERE parent in (SELECT id FROM EffectTag WHERE parent IS null))");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffectTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllWhereParent($parent){
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM EffectTag WHERE parent = '$parent' ORDER BY name ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffectTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getBackparent($id){
        $tag = self::getById($id);
        $parentTag = self::getById($tag[0]->parent);
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM EffectTag WHERE parent = '$parentTag->parent' ORDER BY name ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffectTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getById($id)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM EffectTag WHERE id = '$id'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarEffectTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function insert($name, $parent)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO EffectTag(name, parent) VALUES ('$name','$parent')");
    }

    public static function insertNull($name)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO EffectTag(name) VALUES ('$name')");
    }

    public static function deleteById($id)
    {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM EffectTag WHERE id=" . $id);
    }

    protected static function converteerRijNaarEffectTag($databaseRij)
    {
        return new Tag($databaseRij['id'], $databaseRij['name'], $databaseRij['parent']);
    }

    protected static function converteerRijNaarEffect($databaseRij)
    {
        return new Effect($databaseRij['id'], $databaseRij['name'], $databaseRij['status'], $databaseRij['tag']);
    }
}
