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

    public static function insert($name, $parent)
    {
        return self::getVerbinding()->voerSqlQueryUit("INSERT INTO CauseTag(name, parent) VALUES ('$name','$parent')");
    }

    public static function deleteById($id)
    {
        return self::getVerbinding()->voerSqlQueryUit("DELETE FROM CauseTag WHERE id=" . $id);
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
