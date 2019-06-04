<?php

include_once "Models/Cause.php";
include_once "Models/Tag.php";
include_once "Database/DatabaseFactory.php";

class CauseTagDB
{
    private static function getVerbinding()
    {
        return DatabaseFactory::getDatabase();
    }

    public static function ifLast($id)
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM CauseTag WHERE parent = '$id' ORDER BY id ASC");
        $resultatenArray = array();
        if ($resultaat->num_rows > 0) {
            return false;
        }else{
            return true;
        }
    }
   
    public static function getAll()
    {
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM CauseTag ORDER BY id ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllFirst(){
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM CauseTag WHERE parent IS null ORDER BY name ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllSecond(){
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM CauseTag WHERE parent in (SELECT id FROM CauseTag WHERE parent IS null)");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
 
    public static function getAllThird(){
        $resultaat = self::getVerbinding()->voerSqlQueryUit("Select * from CauseTag where parent in (SELECT id FROM CauseTag WHERE parent in (SELECT id FROM CauseTag WHERE parent IS null))");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllWhereParent($parent){
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM CauseTag WHERE parent = '$parent' ORDER BY name ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getBackparent($id){
        $tag = self::getById($id);
        $parentTag = self::getById($tag[0]->parent);
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM CauseTag WHERE parent = '$parentTag->parent' ORDER BY name ASC");
        $resultatenArray = array();
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
 
    public static function getById($id)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("SELECT * FROM CauseTag WHERE id = '$id'");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }
    
    public static function getSearchTagID($searchq)
    {
        $resultatenArray = array();
        $resultaat = self::getVerbinding()->voerSqlQueryUit("select * from CauseTag where name LIKE '%$searchq%' ORDER BY id ASC");
        for ($index = 0; $index < $resultaat->num_rows; $index++) {
            $databaseRij = $resultaat->fetch_array();
            $nieuw = self::converteerRijNaarCauseTag($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function insert($name, $parent)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO CauseTag(name, parent) VALUES ('$name','$parent')");
    }

    public static function insertNull($name)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO CauseTag(name) VALUES ('$name')");
    }

    public static function deleteById($id)
    {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM CauseTag WHERE id=" . $id);
    }
    
    public static function changeNameTag($tagName, $tagId)
    {
        return self::getVerbinding()->voerSqlQueryUit("UPDATE CauseTag SET name='$tagName' WHERE id=" . $tagId);
    }

    protected static function converteerRijNaarCauseTag($databaseRij)
    {
        return new Tag($databaseRij['id'], $databaseRij['name'], $databaseRij['parent']);
    }

    protected static function converteerRijNaarCause($databaseRij)
    {
        return new Cause($databaseRij['id'], $databaseRij['name'], $databaseRij['tag']);
    }
}
