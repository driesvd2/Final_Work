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

    public static function insert($name, $parent)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO EffectTag(name, parent) VALUES ('$name','$parent')");
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
